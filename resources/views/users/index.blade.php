<h1>List of users</h1>

<div class="listUsers">
<a href="{{ route('users.create') }}">Create user</a>

<table>
    <thead>
   <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Is Admin</th>
        <th>Actions</th>
    </tr>
    </thead>

<tbody>
    @foreach ($users as $user )
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->is_admin ? "admin" : "simple user"}}</td>
        <td class="actions">
            <a href="{{ route('users.edit', $user->id) }}" class="edit">Edit</a>
            <a href="{{ route('users.destroy', $user->id) }}" class="delete">Delete</a>
        </td>
    </tr>
@endforeach
</tbody>

</table>
</div>


<style>
    h1{
   color: seagreen;
   text-align: center;
   padding-top: 20px;
}

.listUsers {
    width: 80% ;
    align-items: center;
    justify-content: center;
    display: flex;
    flex-direction: column;
    padding: 20px ;
    margin:20px auto;
}


.listUsers table {
    width: 100% ;
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.5);
}

.listUsers table th, .listUsers table td {
    border: 1px solid black;
    padding: 10px ;
    font-size: 18px;
    transition: background-color 0.3s, color 0.3s;
    cursor: pointer;

}

.listUsers table th:hover:not(.actions), .listUsers table td:hover:not(.actions) {
    background-color: #eeeeee;
}

a{
    text-decoration: none;
    background-color: seagreen;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    align-self: flex-start;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.5);
}

.actions {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.actions .edit {
    background-color: rgb(0, 53, 105);
    transition: background-color 0.3s;
}

.actions .delete {
    background-color: crimson;
    transition: background-color 0.3s;
}

.actions .edit:hover {
    background-color: rgb(0, 98, 131);
}

.actions .delete:hover {
    background-color: red;
}

</style>
