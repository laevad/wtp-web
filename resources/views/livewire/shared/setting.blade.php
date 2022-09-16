<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center" x-data="{ imagePreview: '{{ auth()->user()->avatar_url }}' }">
                    <input type="file" x-ref="image"
                           class="d-none"
                           x-on:change="
                                         reader = new FileReader();
                                        reader.onload = (event) =>{
                                            imagePreview = event.target.result;
                                            document.getElementById('profileImage').src = `${imagePreview}`;
                                            document.getElementById('profileImage1').src = `${imagePreview}`;
                                        };
                                        reader.readAsDataURL($refs.image.files[0]);
                                    "
                           wire:model="image"
                    >
                    <img class="profile-user-img img-circle"
                         x-on:click="$refs.image.click()"
                         x-bind:src="imagePreview ? imagePreview : '{{ auth()->user()->avatar_url }}'"
                         alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                <p class="text-muted text-center">{{ strtoupper(auth()->user()->role->role) }}</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card" x-data="{ currentTab: $persist('profile') }" wire:ignore.self>
            <div class="card-header p-2">
                <ul class="nav nav-pills" wire:ignore>
                    <li @click.prevent="currentTab = 'profile'" class="nav-item"><a class="nav-link" :class="currentTab == 'profile' ? 'active' : ''" href="#profile"
                                                                                    data-toggle="tab">Settings</a></li>
                    <li @click.prevent="currentTab = 'changePassword'" class="nav-item"><a class="nav-link" :class="currentTab == 'changePassword' ? 'active' : ''" href="#changePassword" data-toggle="tab">Change
                            Password</a></li>
                    <li @click.prevent="currentTab = 'apiKey'" class="nav-item"><a class="nav-link" :class="currentTab == 'apiKey' ? 'active' : ''" href="#apiKey" data-toggle="tab">API Key</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane" :class="currentTab == 'profile' ? 'active' : ''"  id="profile" wire:ignore.self>
                        <form class="form-horizontal" wire:submit.prevent="updateProfile" autocomplete="off">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name')  is-invalid @enderror" id="inputName"
                                           placeholder="Name" wire:model.defer="state.name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email')  is-invalid @enderror" id="inputEmail"
                                           placeholder="Email" wire:model.defer="state.email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{--CHANGE PASS--}}
                    <div class="tab-pane" :class="currentTab == 'changePassword' ? 'active' : ''" id="changePassword" wire:ignore.self>
                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="changePassword">
                            <div class="form-group row">
                                <label for="currentPassword" class="col-sm-3 col-form-label">Current
                                    Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword"
                                           placeholder="Current Password" wire:model.defer="state.current_password">
                                    @error('current_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newPassword" class="col-sm-3 col-form-label">New
                                    Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="newPassword"
                                           placeholder="New Password" wire:model.defer="state.password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passwordConfirmation" class="col-sm-3 col-form-label">Confirm
                                    New Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordConfirmation"
                                           placeholder="Confirm New Password" wire:model.defer="state.password_confirmation">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{--API KEY--}}
                    <div class="tab-pane" :class="currentTab == 'apiKey' ? 'active' : ''" id="apiKey" wire:ignore.self>
                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="apiKey">
                            <div class="form-group row">
                                <label for="googleApiKey" class="col-sm-3 col-form-label">Google API Key</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('googleApiKey') is-invalid @enderror" id="googleApiKey"
                                           placeholder="Google API Key" wire:model.defer="state.api_key">
                                    @error('googleApiKey')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@push('js')
    <script>
        $('[x-ref="profileLink"]').on('click', function () {
            localStorage.setItem('_x_currentTab', '"profile"');
        });
        $('[x-ref="changePasswordLink"]').on('click', function () {
            localStorage.setItem('_x_currentTab', '"changePassword"');
        });
        $('[x-ref="apiKeyLink"]').on('click', function () {
            localStorage.setItem('_x_currentTab', '"apiKey"');
        });
    </script>
@endpush

@push('css')
    <style>
        .profile-user-img:hover {
            background-color: blue;
            cursor: pointer;
        }
    </style>

@endpush

@push('js')


    <script>
        $(document).ready(function () {
            toastr.options = {
                "positionClass": "toast-bottom-right",
                "progressBar": true,
            }
            window.addEventListener('updated', event=>{
                toastr.success(event.detail.message, 'Success!');
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            Livewire.on('nameChanged',(name)=>{
                $('[x-ref="username"]').text(name);
            });
        });
    </script>
@endpush
