@include("practicetype::student.numbers_sum")
<style>
  .center-left {
    margin-right:1400px;
  }
</style>
<div class="center-left">
  <form action="{{ route('student.practice.done', ['courseId' => $course->id, 'practiceId' => $practice->id]) }}" method="post">
  @csrf
    <button class="btn btn-success" type="submit" style="color: white;">markedAsDone</button>
    </form>
</div>  
<script>

      document.querySelector("#sendResult").addEventListener('click', function prossesResult() {
        const inputValue = parseInt(document.getElementById("inputValue").value);

  if( sumNumber === inputValue){

    console.log("hi from inculde2");

    $.ajax({
        method: "POST",
        url: "{{ route('student.practice.done', ['courseId' => $course->id, 'practiceId' => $practice->id])}}",
        data: {
        },
        success: function (one, two, three) {
          console.log("hi from  end inculde");
            toastr.success('updated successfully')
        },
        error: function (one, two, three) {
          console.log("hi from  errorrrr inculde");

            toastr.error('error')
        },
    });
    
  }

});
</script>