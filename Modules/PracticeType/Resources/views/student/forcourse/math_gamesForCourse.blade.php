@include("practicetype::student.math_games")
<!-- <div class="center-left">
  <form action="{{ route('student.practice.done', ['courseId' => $course->id, 'practiceId' => $practice->id]) }}" method="post">
  @csrf
    <button class="btn btn-success" type="submit" style="color: white;">markedAsDone</button>
    </form>
</div>   -->
<script>
      document.querySelector("#submit").addEventListener('click', function prossesResult() {

const StudetntConvert = getAbacusValue(arrResult);
console.log(StudetntConvert);

const resultConvert = getAbacusValue(result);
if(resultConvert === StudetntConvert){
  console.log("hi from inculde");


    $.ajax({
        method: "POST",
        url: "{{ route('student.practice.done', ['courseId' => $course->id, 'practiceId' => $practice->practice_id])}}",
        data: {
        },
        success: function (one, two, three) {
            toastr.success('updated successfully')
        },
        error: function (one, two, three) {
            toastr.error('error')
        },
    });
    
}
});
</script>