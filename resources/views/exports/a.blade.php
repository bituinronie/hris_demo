<table>
    <thead>
        <tr>
            <td style=" background-color: #FFFFFF;" width="2"></td>
            <td style=" background-color: #FFFFFF;" width="40"></td>
            <td style=" background-color: #FFFFFF;" width="25"></td>
            <td style=" background-color: #FFFFFF;" width="20"></td>
            <td style=" background-color: #FFFFFF;" width="20"></td>
            <td style=" background-color: #FFFFFF;" width="20"></td>
            <td style=" background-color: #FFFFFF;" width="20"></td>
            <td style=" background-color: #FFFFFF;" width="20"></td>
            <td style=" background-color: #FFFFFF;" width="20"></td>
            <td colspan=2 style=" background-color: #FFFFFF;" width="24"></td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF;" valign="center" colspan="11" height=15>
                <p>{{ $upperHeader }}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF;" valign="center" colspan="11" height=15>
                <p>{{ $departmentName }}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF;" valign="center" colspan="11" height=20>
                <b>{{ $officeName }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #FFFFFF; font-size: 20px;" valign="center" colspan="11" height=20>
                <b>{{ $year }} SUMMARY OF APPRAISAL</b>
            </td>
        </tr>

        <tr>
            <th style="text-align: center; border: 1px solid black;" valign="center" rowspan="2" height="40">NO.</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" rowspan="2" height="40">NAME</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" rowspan="2" height="40">Position/SG</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" colspan="2" height="20">January - June Ratings</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" colspan="2" height="20">July - December Ratings</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" colspan="2" height="20">Rating of New Hired Personnel</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" rowspan="2" colspan="2" height="40">Remarks</th>
        </tr>
        <tr>
            <th style="text-align: center; border: 1px solid black;" valign="center" height="20">Numerical</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" height="20">Adjectival</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" height="20">Numerical</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" height="20">Adjectival</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" height="20">Numerical</th>
            <th style="text-align: center; border: 1px solid black;" valign="center" height="20">Adjectival</th>
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
                    <p>{{ $item->name }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->position }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->{'1ST'}->numeric }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->{'1ST'}->adjectival }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->{'2ND'}->numeric }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->{'2ND'}->adjectival }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->{'OTHERS'}->numeric }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" valign="center">
                    <p>{{ $item->{'OTHERS'}->adjectival }}</p>
                </td>
                <td style="text-align: center; border: 1px solid black;" colspan=2 valign="center">
                    <p>{{ $item->remarks }}</p>
                </td>
            </tr>
            {{ $i++ }}
        @endforeach
    </tbody>
    <tr>
        <td style="border: 1px solid #ffffff;" colspan="11"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #ffffff;" colspan="11"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #ffffff;" colspan="5">Prepared by:</td>
        <td style="border: 1px solid #ffffff;">&nbsp;</td>
        <td style="border: 1px solid #ffffff;" colspan="5">NOTED:</td>
    </tr>
    <tr>
        <td style="border: 1px solid #ffffff;" colspan="11" height="30"></td>
    </tr>
    
    <tr>
        <td style="margin: 20px; margin-top: 20px; vertical-align: middle; border: 1px solid #ffffff; width: 50%;" colspan="5"><b>{{ $prepared }}</b></td>
        <td style="border: 1px solid #ffffff;">&nbsp;</td>
        <td style="margin: 20px; margin-top: 20px; vertical-align: middle; border: 1px solid #ffffff; width: 50%;" colspan="5"><b>{{ $noted }}</b></td>
    </tr>
    <tr>
        <td style="border: 0px solid #ffffff; text-align: center;" colspan="5">{{ $preparedPosition }}</td>
        <td style="border: 1px solid #ffffff;">&nbsp;</td>
        <td style="border: 0px solid #ffffff; text-align: center;" colspan="5">{{ $notedPosition }}</td>
    </tr>
</table>