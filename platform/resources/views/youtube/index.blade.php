<form action="{{ route('youtube.search') }}" method="GET">
    <input type="text" name="keyword" placeholder="ادخل كلمة مفتاحية" required />
    <button type="submit">بحث</button>
</form>
