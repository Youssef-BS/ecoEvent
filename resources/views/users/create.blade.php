<h1>Create user</h1>

<form  action="{{route('users.store')}}" method="POST">
     @csrf
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">
    <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
    <input type="submit" value="create"/>
</form>
