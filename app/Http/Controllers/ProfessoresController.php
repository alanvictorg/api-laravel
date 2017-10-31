<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProfessoreCreateRequest;
use App\Http\Requests\ProfessoreUpdateRequest;
use App\Repositories\ProfessoreRepository;
use App\Validators\ProfessoreValidator;


class ProfessoresController extends Controller
{

    /**
     * @var ProfessoreRepository
     */
    protected $repository;

    /**
     * @var ProfessoreValidator
     */
    protected $validator;

    public function __construct(ProfessoreRepository $repository, ProfessoreValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

      /**
     * @return ProfessoreRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $professores = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $professores,
            ]);
        }

        return view('professores.index', compact('professores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProfessoreCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProfessoreCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $professore = $this->repository->create($request->all());

            $response = [
                'message' => 'Professore created.',
                'data'    => $professore->toArray(),
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
        $professore = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $professore,
            ]);
        }

        return view('professores.show', compact('professore'));
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

        $professore = $this->repository->find($id);

        return view('professores.edit', compact('professore'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ProfessoreUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ProfessoreUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $professore = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Professore updated.',
                'data'    => $professore->toArray(),
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
                'message' => 'Professore deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Professore deleted.');
    }
    
     public function getProfessor($professorid)
    {
        $professor = $this->getRepository()->find($professorid);
        
        return $professor->toArray();
    }
}
