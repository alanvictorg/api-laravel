<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TurmaCreateRequest;
use App\Http\Requests\TurmaUpdateRequest;
use App\Repositories\TurmaRepository;
use App\Validators\TurmaValidator;


class TurmasController extends Controller
{

    /**
     * @var TurmaRepository
     */
    protected $repository;

    /**
     * @var TurmaValidator
     */
    protected $validator;

    public function __construct(TurmaRepository $repository, TurmaValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $turmas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $turmas,
            ]);
        }

        return view('turmas.index', compact('turmas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TurmaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TurmaCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $turma = $this->repository->create($request->all());

            $response = [
                'message' => 'Turma created.',
                'data'    => $turma->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $turma = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $turma,
            ]);
        }

        return view('turmas.show', compact('turma'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $turma = $this->repository->find($id);

        return view('turmas.edit', compact('turma'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  TurmaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(TurmaUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $turma = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Turma updated.',
                'data'    => $turma->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Turma deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Turma deleted.');
    }
}
