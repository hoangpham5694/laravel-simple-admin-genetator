<form action="{{route('simple_admin_generation.admin.update_password', $admin->id)}}" method="POST">
    @csrf
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Update Password</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="txtPassword">Password</label>
                <input type="password" name="password" id="txtPassword" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                <span id="txtPassword-error" class="error invalid-feedback">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="txtPasswordConfirm">Confirm Password</label>
                <input type="password" name="password_confirmation" id="txtPasswordConfirm" class="form-control">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Update password</button>
        </div>
    </div>
</form>
