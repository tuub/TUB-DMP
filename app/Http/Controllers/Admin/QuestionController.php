<?php
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

class QuestionController extends Controller {

    protected $question;
    protected $template;
    protected $section;
    protected $content_type;

    public function __construct( Question $question, Template $template, Section $section, ContentType $content_type )
    {
        $this->question = $question;
        $this->template = $template;
        $this->section = $section;
        $this->content_type = $content_type;

        //$this->question->rebuild(true);
    }


    public function index(Section $section)
    {
        $questions = $this->question->roots()->where('section_id', $section->id)->orderBy('order', 'asc')->get();
        $template = $section->template;
        return view('admin.question.index', compact('section', 'questions', 'template'));
    }


    public function create(Request $request)
    {
        $section = $this->section->find($request->section);
        $question = new $this->question;
        $question->is_active = 1;
        $question->is_mandatory = 1;
        $template = $section->template;
        $content_types = $this->content_type->get()->pluck('title', 'id');
        $position = $this->question->getNextOrderPosition($section);
        return view('admin.question.create', compact('question','template', 'section', 'content_types', 'position'));
    }


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


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $question = $this->question->find($id);
        $template = $question->template;
        $section = $question->section;
        $content_types = $this->content_type->get()->pluck('title', 'id');

        return view('admin.question.edit', compact('question','template', 'section', 'content_types'));
    }


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

        return redirect()->route('admin.section.questions.index', $question->section_id);
    }


    public function destroy(DeleteQuestionRequest $request, $id)
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        /* The operation */
        $op = $this->question->updatePositions($request->all());

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Sorting updated!', 'success');
        } else {
            $notification = new Notification(500, 'Sorting not updated!', 'error');
        }

        /* The JSON response */
        if ($request->ajax()) {
            return response()->json([
                'response' => $notification->status,
                'message' => $notification->message
            ]);
        } else {
            abort(403, 'Direct access is not allowed.');
        }
    }
}
