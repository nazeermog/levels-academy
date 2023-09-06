<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
  .center-left {
    margin-right:1000px;
  }
</style>
</head>
<body>
@include("practicetype::student.abacus")
<div class="center-left">
  <form action="{{ route('student.practice.done', ['courseId' => $course->id, 'practiceId' => $practice->id]) }}" method="post">
  @csrf
    <button class="btn btn-success" type="submit" style="color: white;">markedAsDone</button>
    </form>
</div>  
</body>
</html>

