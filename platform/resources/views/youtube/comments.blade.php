<h3>تحليل التعليقات:</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>التعليق</th>
        <th>التحليل</th>
    </tr>
    @foreach($comments as $comment)
        <tr>
            <td>{{ $comment['text'] }}</td>
            <td>{{ $comment['sentiment'] }}</td>
        </tr>
    @endforeach
</table>
