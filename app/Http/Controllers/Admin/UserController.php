<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddRequest;
use App\Http\Requests\Users\EditRequest;

use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\StoreRepository;
use App\Repositories\UserRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(StoreRepository $storeRepository, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->middleware('permission:users.index', ['only' => ['index', 'add', 'store']]);
        $this->userRepository  = $userRepository;
        $this->roleRepository  = $roleRepository;
        $this->storeRepository = $storeRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::all();
            return Datatables::of($user)
                ->addIndexColumn()
                ->addColumn('rol', function ($user) {
                    return $user->rol();
                })
                ->addColumn('vincular', function ($user) {
                    return '<a href="' . route('users.vincular.tienda', ['id' => $user->id]) . '"> <i class="fa fa-link"></i> </a>';
                })
                ->addColumn('tienda', function ($user) {
                    return $user->store_active();
                })
                ->addColumn('edit', function ($user) {
                    $ruta = 'edit(' . $user->id . ",'" . route('users.edit') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($user) {
                    $ruta = 'destroy(' . $user->id . ",'" . route('users.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['rol', 'vincular', 'tienda', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function add()
    {
        try {
            $roles = $this->roleRepository->getActives();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.users.insertByAjax', compact('roles'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(AddRequest $request)
    {
        try {
            $data             = $request->except(['_token', 'rol_id']);
            $data['active']   = 1;
            $data['password'] = Hash::make($data['password']);
            $role             = $this->roleRepository->getOne($request->rol_id);
            $user             = $this->userRepository->create($data);

            $user->assignRole($role);

            return new JsonResponse([
                'msj'  => 'Usuario creado correctamente!',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit(Request $request)
    {
        try {
            $user   = $this->userRepository->getOne($request->id);
            $roles  = $this->roleRepository->getActives();
            $stores = $user->stores;
            return new JsonResponse([
                'msj'  => 'Registro guardado correctamente!',
                'type' => 'success',
                'html' => view('admin.users.insertByAjax', compact('user', 'roles', 'stores'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function editProfile(Request $request)
    {
        $user  = $this->userRepository->getOne(Auth::user()->id);
        $roles = $this->roleRepository->getActives();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(EditRequest $request)
    {
        try {
            $data = $request->except(['_token', 'user_id', 'active', 'rol_id', 'password', 'confirm-password']);
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $this->userRepository->update($request->input('user_id'), $data);

            $user = $this->userRepository->getOne($request->user_id);
            $role = $this->roleRepository->getOne($request->rol_id);
            $user->syncRoles($role);

            return new JsonResponse([
                'msj'  => 'Usuario actualizado correctamente!',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        $this->userRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }

    public function vincularTienda(Request $request)
    {
        $user   = $this->userRepository->getOne($request->id);
        $stores = $this->storeRepository->getAll();
        return view('admin.users.vincular', compact('user', 'stores'));
    }

    public function vincularTiendaUpdate(Request $request)
    {
        $user = User::find($request->id);
        $user->stores()->sync($request->get('stores'));
        $arrStores = $user->stores->pluck('id')->toArray();

        if (!in_array($user->store_active, $arrStores)) {
            $user->store_active = null;
            $user->save();
        }

        $notification = [
            'message'    => 'Relacion actualizada !',
            'alert-type' => 'info',
        ];

        return redirect()->route('users.index')->with($notification);
    }
}
