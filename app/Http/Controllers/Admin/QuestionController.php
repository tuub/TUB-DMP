<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use App\Template;
use App\Section;
use App\ContentType;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Library\Sanitizer;
use App\Library\Notification;


/**
 * Class QuestionController
 *
 * @package App\Http\Controllers\Admin
 */
class QuestionController extends Controller {

    protected $question;
    protected $template;
    protected $section;
    protected $content_type;


    /**
     * QuestionController constructor.
     *
     * @param Question    $question
     * @param Template    $template
     * @param Section     $section
     * @param ContentType $content_type
     */
    public function __construct( Question $question, Template $template, Section $section, ContentType $content_type )
    {
        $this->question = $question;
        $this->template = $template;
        $this->section = $section;
        $this->content_type = $content_type;
    }


    /**
     * Renders the questions for the given section object.
     *
     * @param Section $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Section $section)
    {
        $questions = $this->question->roots()->where('section_id', $section->id)->orderBy('order')->get();
        $template = $section->template;

        return view('admin.question.index', compact('section', 'questions', 'template'));
    }


    /**
     * Renders the create form for the given section (in request).
     *
     * @todo: Refactor so it does not need a request var here!
     *
     * @uses Question::getNextOrderPosition()
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $section = $this->section->find($request->section);
        $question = new $this->question;
        $question->is_active = 1;
        $question->is_mandatory = 1;
        $template = $section->template;
        $content_types = $this->content_type->active()->get()->pluck('title', 'id');
        $position = $this->question->getNextOrderPosition($section);

        return view('admin.question.create', compact('question','template', 'section', 'content_types', 'position'));
    }


    /**
     * Stores a new question.
     *
     * @param CreateQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateQuestionRequest $request)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* Validate input */

        /* The operation */
        $op = $question = $this->question->create($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully created the question!', 'success');
        } else {
            $notification = new Notification(500, 'Error while creating the question!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.section.questions.index', $question->section_id);
    }


    /**
     * Renders the edit form for the given question ID.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $question = $this->question->find($id);
        $template = $question->template;
        $section = $question->section;
        $content_types = $this->content_type->active()->get()->pluck('title', 'id');
        $position = $question->order;

        return view('admin.question.edit', compact('question','template', 'section', 'content_types', 'position'));
    }


    /**
     * Updates a question with the given ID.
     *
     * Description
     *
     * @param UpdateQuestionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* The validation */

        /* Get object */
        $question = $this->question->findOrFail($id);

        /* The operation */
        $op = $question->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the question!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the question!', 'error');
        }
        $notification->toSession($request);

        $this->question->rebuild();

        return redirect()->route('admin.section.questions.index', $question->section_id);
    }


    /**
     * Deletes a question with the given ID.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        /* Get object */
        $question = $this->question->find($id);

        /* The operation */
        $op = $question->delete();

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the question!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the question!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.section.questions.index', $question->section_id);
    }


    /**
     * Updates positions of the given sections set.
     *
     * @uses \App\Question::updatePositions
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function sort(Request $request)
    {
        if ($request->ajax()) {

            /* The operation */
            $op = $this->question->updatePositions($request->all());

            /* The notification */
            if ($op) {
                $notification = new Notification(200, 'Sorting updated!', 'success');
            } else {
                $notification = new Notification(500, 'Sorting not updated!', 'error');
            }

            /* The JSON response */
            return $notification->toJson($request);
        }

        return null;
    }
}
