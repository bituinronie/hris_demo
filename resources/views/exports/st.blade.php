<table>
    <thead>
        <tr>
            <td style=" background-color: #FFFFFF;" width="5.43"></td>
            <td style=" background-color: #FFFFFF;" width="10.57"></td>
            <td style=" background-color: #FFFFFF;" width="27.57"></td>
            <td style=" background-color: #FFFFFF;" width="18.71"></td>
            <td style=" background-color: #FFFFFF;" width="50.57"></td>
            <td style=" background-color: #FFFFFF;" width="8"></td>
            <td style=" background-color: #FFFFFF;" width="18.29"></td>
            <td style=" background-color: #FFFFFF;" width="18.29"></td>
            <td style=" background-color: #FFFFFF;" width="10"></td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF;" valign="center" colspan="9" height=15>
                <p>{{ $upperHeader }}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF;" valign="center" colspan="9" height=15>
                <p>{{ $departmentName }}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF;" valign="center" colspan="9" height=20>
                <b>{{ $officeName }}</b>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>NO</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Year</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Program</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Conducted By</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Description</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Day/s</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Date From</b>
            </td>
            <td style="text-align: center; border: 1px solid black;" valign="center" height="55">
                <b>Date To</b>
            </td>
            <td style="text-align: center; border: 1px solid black; font-size: 10px;" valign="center" height="55">
                <b>Number of <br>Recorded <br>Employees</b>
            </td>
        </tr>
    </thead>
    <tbody>
        {{ $i = 1 }}
        @foreach ($items as $item)
            <tr>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $i }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->year }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->program }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->conducted_by }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->description }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->day }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->date_from }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->date_to }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->number }}</p>
                </td>
            </tr>
            {{ $i++ }}
        @endforeach
    </tbody>
</table>