<?php

namespace HoangPhamDev\SimpleAdminGenerator\Http\Controllers;

use App\Http\Controllers\Controller;
use HoangPhamDev\SimpleAdminGenerator\Models\Admin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $meta = [
            'title' => 'List admin',
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'url' => route('simple_admin_generation.dashboard')
                ],
                [
                    'name' => 'List Admin'
                ]
            ]
        ];
        $admins = Admin::query()->paginate(10);
        return view('simple_admin_generation::admin.index', compact('meta', 'admins'));
    }

    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
    {
        $meta = [
            'title' => 'Edit admin',
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'url' => route('simple_admin_generation.dashboard')
                ],
                [
                    'name' => 'List Admin',
                    'url' => route('simple_admin_generation.admin.index')
                ],
                [
                    'name' => 'Edit',
                ]
            ]
        ];
        $admin = Admin::query()->findOrFail($id);
        return view('simple_admin_generation::admin.edit', compact('meta', 'admin'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Redirector|Application|RedirectResponse
     */
    public function update(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $admin = Admin::query()->findOrFail($id);
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->email, 'email'),
            ],
            'first_name'  => 'required|max:50',
            'last_name'  => 'required|max:50',
            'is_super_user' => [
                'sometimes',
                Rule::in([0, 1])
            ]
        ]);
        $admin->update($validated);
        return redirect(route('simple_admin_generation.admin.edit', $id))->with('success', 'Update success');
    }

    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function detail($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
    {
        $meta = [
            'title' => 'Detail admin',
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'url' => route('simple_admin_generation.dashboard')
                ],
                [
                    'name' => 'List Admin',
                    'url' => route('simple_admin_generation.admin.index')
                ],
                [
                    'name' => 'Edit',
                ]
            ]
        ];
        $admin = Admin::query()->findOrFail($id);
        return view('simple_admin_generation::admin.detail', compact('meta', 'admin'));
    }
    public function update_password(Request $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $admin = Admin::query()->findOrFail($id);
        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        $validated['password'] = bcrypt($validated['password']);
        $admin->update($validated);
        return redirect()->back()->with('success', 'Update password success');
    }

    public function destroy(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $admin = Admin::query()->findOrFail($request->id);

        $admin->delete();
        return redirect(route('simple_admin_generation.admin.index'))->with('success', 'Delete success');
    }
}