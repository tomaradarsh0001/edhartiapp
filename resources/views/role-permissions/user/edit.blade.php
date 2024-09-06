@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <div>
        <style>
            .form-select[multiple] {
                padding-right: .75rem;
                background-image: none;
                min-height: 310px !important;
            }

            .custom-dropdown {
                width: 100%;
            }

            .dropdown-menu.show {
                width: 100%;
            }

            .horizontal-menu {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                /* Creates 4 equal columns */
                max-height: 500px;
                overflow-y: auto;
                padding: 0;
                margin: 0;
                list-style: none;
                gap: 10px;
                /* Adjusts the space between items */
                width: 100%;
            }

            .horizontal-menu li {
                display: flex;
                align-items: center;
            }
        </style>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Create User</h6>
                    <form action="{{ url('users/' . $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="email" value="{{ $user->email }}" class="form-control"
                            placeholder="Email">
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                    placeholder="Name" required>
                            </div>
                            <div class="col-12 col-lg-8 pb-4">
                                <label for="Roles" class="form-label">Select Permissions</label>
                                <div class="dropdown">
                                    <button class="btn btn-secondary custom-dropdown" type="button">
                                        Select permissions
                                    </button>
                                    <ul class="dropdown-menu horizontal-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($permissions as $permission)
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" name="permissions[]" class="permission-checkbox"
                                                        value="{{ $permission->name }}"
                                                        @if ($user->hasPermissionTo($permission->name)) checked @endif>
                                                    {{ $permission->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div id="permissionsError" class="text-danger"></div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="Roles" class="form-label">Select Roles</label>
                                <select class="form-select" name="roles[]" aria-label="Default select example" multiple
                                    required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}"
                                            {{ in_array($role, $userRoles) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
