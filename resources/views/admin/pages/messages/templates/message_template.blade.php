<table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_1">
    <thead>
        <tr class="">
            <th id="ID" style="width: 50px;">
                <input id="chk-all" type="checkbox">
            </th>
            <th> الاسم </th>
            <th> البريد الالكتروني </th>
            <th> العنوان </th>
            <th> الرساله </th>
            <th> انشئ في </th>
        </tr>
    </thead>
    <tbody>
        @foreach($messages as $message)
        <tr>
            <td class="a-center ID even pointer {{ $message->seen ? 'success' : 'warning' }}">
                <input name="ids[]" class="chk-box" value="{{ $message->id}}" type="checkbox">
            </td>
            <td> {{$message->name}} </td>
            <td> {{$message->email}} </td>
            <td> {{$message->subject}} </td>
            <td> {{$message->message}} </td>
            <td> {{$message->created_at}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
