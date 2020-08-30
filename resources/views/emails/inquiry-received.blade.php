<p>A new inquiry has been submitted:</p>
<table >
    <tr>
        <td>ID</td>
        <td>{{ $inquiry->id }}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>{{ $inquiry->name }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ $inquiry->email }}</td>
    </tr>
    <tr>
        <td>Phone</td>
        <td>{{ $inquiry->phone }}</td>
    </tr>
    <tr>
        <td>Submitted At</td>
        <td>{{ $inquiry->created_at }}</td>
    </tr>
</table>
<style>
    table, td, th {  
        border: 1px solid #ddd;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 15px;
        text-align: left;
    }
</style>