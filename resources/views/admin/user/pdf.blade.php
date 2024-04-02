<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>{{ __('User Profile') }}</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>{{ __('User Profile') }}</u></h3>
    <label>
        <font size="1">{{ __('Report Date') }}:</font>
        <font color="blue" size="1">
            @php
                $horafecha = new DateTime("now", new DateTimeZone(Auth::user()->timezone));
                $horafecha = $horafecha->format('d-m-Y, H:i:s')
            @endphp
            {{ $horafecha }} ({{ Auth::user()->timezone }})
        </font>
    </label>
    <br>

    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th align="right">
                    <font size="1">{{ __('Role') }}:</font>
                </th>
                <td align="left">
                    <font size="1">{{ $user->role_as == '0' ?'User' : 'Admin' }}</font>
                </td>
                <th align="right">
                    <font size="1">{{ __('Name') }}:</font>
                </th>
                <td>
                    <font size="1">{{ $user->name }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Email:</font>
                </th>
                <td>
                    <font size="1">{{ $user->email }}</font>
                </td>
                <th align="right">
                    <font size="1">{{ __('Phone') }}:</font>
                </th>
                <td>
                    <font size="1">{{ $user->phone }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">{{ __('Address') }} 1:</font>
                </th>
                <td colspan="3">
                    <font size="1">{{ $user->address1 }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">{{ __('Address') }} 2:</font>
                </th>
                <td colspan="3">
                    <font size="1">{{ $user->address2 }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">{{ __('City') }}:</font>
                </th>
                <td>
                    <font size="1">{{ $user->city }}</font>
                </td>
                <th align="right">
                    <font size="1">{{ __(('State/Province')) }}:</font>
                </th>
                <td>
                    <font size="1">{{ $user->state }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">{{ __('Country') }}:</font>
                </th>
                <td>
                    <font size="1">{{ $user->country }}</font>
                </td>
                <th align="right">
                    <font size="1">{{ __('Zip / Postal Code') }}:</font>
                </th>
                <td>
                    <font size="1">{{ $user->zipcode }}</font>
                </td>
            </tr>

        </thead>
        {{-- <tbody>
            <tr>
                <td align="center">
                    <font size="1">hola</font>
                </td>
                <td align="center">
                    <font size="1">hola 2</font>
                </td>
            </tr>
        </tbody> --}}
    </table>
</body>

</html>
