<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Q PHP Test</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="{{ url('dashboard') }}">Home</a></li>
      <li><a href="{{ url('authors') }}">Authors</a></li>
      <li><a href="{{ url('view_add_author') }}">Add Authors</a></li>
      <li><a href="{{ url('view_add_book') }}">Add Books</a></li>
      <li><a href="{{ url('logout') }}">Logout</a></li>
    </ul>
  </div>
</nav>