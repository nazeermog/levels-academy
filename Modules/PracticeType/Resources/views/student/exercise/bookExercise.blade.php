@extends("student.layouts.dashboard")

@section("content")
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="row">
        <form id="searchForm" class="d-flex">
            <div class="input-group input-group-lg">
                <input class="form-control form-control-lg" type="text" id="exerciseCode" placeholder="Enter Exercise Code">
                <button class="btn btn-primary btn-lg" type="button" onclick="searchExercise()">Search</button>
            </div>
        </form>
    </div>
</div>

<script>
    function searchExercise() {
        const exerciseCode = document.getElementById("exerciseCode").value.trim();
       
            fetch(`/student/practice/check-exercise/${exerciseCode}`)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    if (data.exists) {
                        window.open(`/student/practice/exercise/${exerciseCode}/types/abacus`, "_blank");
                    } else {
                        alert("Exercise not found");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error checking exercise');
                });
        } 
    
    
</script>
@endsection
