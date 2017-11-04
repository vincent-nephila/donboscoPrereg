<div>
    <p>Hi {{$info->firstname}} {{$info->lastname}}</p>
    <p style="text-indent: 50px;">
        Please access the account given to you to be able to select the desired elective for the second semester.
    </p>

    <table>
        <tr>
            <td>
                User ID: 
            </td>
            <td>
                {{$info->idno}}
            </td>
        </tr>
        <tr>
            <td>
                New Password: 
            </td>
            <td>
                {{$password}}
            </td>
        </tr>
    </table>
    
    Please log in at {{url('/login')}}
</div>