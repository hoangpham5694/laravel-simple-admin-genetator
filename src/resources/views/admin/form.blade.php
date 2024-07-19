<div class="form-group">
    <label for="txtEmail">Email</label>
    <input type="email" id="txtEmail" name="email" value="{{old('email', $admin->email)}}" class="form-control @error('email') is-invalid @enderror">
    @error('email')
    <span id="txtEmail-error" class="error invalid-feedback">{{$message}}</span>
    @enderror

</div>
<div class="form-group">
    <label for="txtFirstName">First name</label>
    <input type="text" id="txtFirstName" name="first_name" value="{{old('first_name', $admin->first_name)}}" class="form-control @error('first_name') is-invalid @enderror">
    @error('first_name')
    <span id="txtFirstName-error" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    <label for="txtLastName">LastName</label>
    <input type="text" id="txtLastName" name="last_name" value="{{old('last_name', $admin->last_name)}}" class="form-control @error('last_name') is-invalid @enderror">
    @error('last_name')
    <span id="txtLastName-error" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    <label for="selectSuperUser">Super User</label>
    <select id="selectSuperUser" name="is_super_user" class="form-control custom-select @error('is_super_user') is-invalid @enderror">
        <option value="1" @selected(old('is_super_user', $admin->is_super_user) == 1)>Yes</option>
        <option value="0" @selected(old('is_super_user', $admin->is_super_user) == 0)>No</option>
    </select>
    @error('is_super_user')
    <span id="selectSuperUser-error" class="error invalid-feedback">{{$message}}</span>
    @enderror
</div>