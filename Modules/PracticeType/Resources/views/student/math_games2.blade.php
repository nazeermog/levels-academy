@extends("student.layouts.dashboard")
@push('css')
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
      crossorigin="anonymous"
    />
  <style>
    
      .question-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #93bfcf;
      }

      .calc-number {
        font-size: 2rem;
        font-weight: bold;
      }

      .result-input {
        max-width: 500px;
        margin: auto;
        text-align: center;
      }
      .result-input label {
        color: #939393;
      }

      .timer {
        font-size: 2rem;
        font-weight: bolder;
        color: green;
      }

      .keypad .btn {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
      }

      .next-btn {
        width: 100px;
        background-color: #489fb7;
      }

      .number-swiper .swiper-slide {
        background-color: #fff;
      }
  </style>
    <link rel="stylesheet" href="./assets/style/style.css"/>
@endpush
@section("content")
<div class="container mt-5">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center">
          <span class="question-number"> Question 1 </span>
          <span class="timer" id="timer"></span>
        </div>
        <div class="text-center slider-in">
          <div class="swiper number-swiper">
            <div class="swiper-wrapper"></div>
          </div>
        </div>
        <div class="result-input">
          <label for="exampleFormControlInput1" class="form-label"
            >Answer</label
          >
          <input type="text" name="" id="output" class="form-control" />
        </div>
        <div class="keypad text-center mt-2">
          <div class="mb-1">
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(1)"
            >
              1
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(2)"
            >
              2
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(3)"
            >
              3
            </button>
          </div>
          <div class="mb-1">
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(4)"
            >
              4
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(5)"
            >
              5
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(6)"
            >
              6
            </button>
          </div>

          <div class="mb-1">
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(7)"
            >
              7
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(8)"
            >
              8
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(9)"
            >
              9
            </button>
          </div>
          <div>
            <button
              class="btn btn-secondary number-btn"
              onclick="deleteFromInput()"
            >
              >
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput(0)"
            >
              0
            </button>
            <button
              class="btn btn-secondary number-btn"
              onclick="appendToInput('.')"
              id="comma"
            >
              .
            </button>
          </div>
        </div>
        <div class="mt-3 text-center">
          <button type="button" class="btn btn-primary next-btn" id="next-btn">
            Submit
          </button>
          <button type="button" class="btn btn-success d-none" id="result">
            Result
          </button>
        </div>
      </div>
    </div>
@endsection

@push('js')
<script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/script.js"></script>
<script>

const data = <?php echo json_encode($randomNumbers) ?>;
console.log(data);

const sliderDev = document.querySelector(".number-swiper .swiper-wrapper");
const inputELe = document.querySelector("#output");
const nextBtn = document.querySelector("#next-btn");
const ResultBtn = document.querySelector("#result");
const questionNumber = document.querySelector(".question-number");
const numberBtn = document.querySelectorAll(".number-btn");

const answers = [];

const correctAnswer = data.map((e) => e.reduce((acc, curr) => acc + curr, 0));

const timeSLideDelay = 1300;

const timerSec = <?php echo json_encode($timer) ?>;


console.log(correctAnswer);

let currentIndex = 0;
let myResults = [];

function displayMatrix(index) {
  let numbersHtml = data[index].map(num => `<div>${num}</div>`).join('');
  const html = `
          <div class="swiper-slide">
            <div class="calc-number">${numbersHtml}</div>
          </div>
  `;
  sliderDev.insertAdjacentHTML("beforeend", html);
}
displayMatrix(currentIndex);
startSlider();

nextBtn.addEventListener("click", function () {
  sliderDev.innerHTML = "";
  if (Number(inputELe.value) === correctAnswer[currentIndex]) {
    console.log(inputELe.value, correctAnswer[currentIndex]);
    console.log("true");
  } else {
    console.log("false");
  }
  const inputResult = inputELe.value;

  if (Number(inputResult) == correctAnswer[currentIndex]) {
    console.log("new ajax inside");

   $.ajax({
        method: "POST",
        url: "{{ route('student.exercise.done', ['practiceId' => $practice->practice_id])}}",
        data: {},
        success: function(one, two, three) {
          toastr.success('updated successfully')
        },
        error: function(one, two, three) {
          toastr.error('error')
        },
      });
    }
  $.ajax({
            method: "POST",
            url: "{{ route('student.practice.store')}}",
            data: {
                practice_id: {{$practice->practice_id}},
                practice_type_id: {{$practice->id}},
                level_title: {{$practice->id}},
                result_student: Number(inputResult) ,
                result_true: correctAnswer[currentIndex],
                student_id: {{auth()->user()->id}},
                is_true:Number(inputResult) === correctAnswer[currentIndex] ,
                seconds_speed: null,
                card_number: null,
                range_number_from: {{$practice ->range_number_from }},
                range_number_to: {{$practice->range_number_to}}
                // timer: {{$practice->timer}}
            },
            success: function (one, two, three) {
                toastr.success('updated successfully')
            },
            error: function (one, two, three) {
                toastr.error('error')
            },
        });



  if (currentIndex < data.length - 1) {
    currentIndex++;
    displayMatrix(currentIndex);
    startSlider();
    myResults.push(Number(inputResult));
    console.log("my Result =>", myResults);
    inputELe.value = "";
    questionNumber.textContent = `Question ${currentIndex + 1}`;
  } else if (currentIndex === data.length - 1) {
    displayMatrix(currentIndex);
    startSlider();
    myResults.push(Number(inputResult));
    console.log("my Result =>", myResults);
    inputELe.value = "";
    endResult();
  } else {
    console.log("dsd");
  }
});

function endResult() {
  inputELe.disabled = true;
  nextBtn.disabled = true;
  numberBtn.forEach((btn) => {
    btn.disabled = true;
  });
  ResultBtn.classList.remove("d-none");
}
ResultBtn.addEventListener("click", function () {
  const sumResult = myResults.reduce((acc, curr) => acc + curr);
  console.log(sumResult);
});
let commaAdded = false;
const commaBtn = document.querySelector("#comma");
function appendToInput(number) {
  var outputElement = document.getElementById("output");
  outputElement.value += number;

  if (!commaAdded && number === ".") {
    commaAdded = true;
    commaBtn.disabled = true;
  }
}

function deleteFromInput() {
  var textInput = document.getElementById("output");
  let currentText = textInput.value;
  console.log("dsdasdas");
  if (currentText.at(-1) === ".") {
    commaBtn.disabled = false;
    commaAdded = false;
  }
  if (currentText.length > 0) {
    currentText = currentText.slice(0, -1);
    textInput.value = currentText;
  }
}

function startSlider() {
  var swiper = new Swiper(".number-swiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
      delay: timeSLideDelay,
    },
    loop: false,
    effect: "fade",
  });
  swiper.on("slideChange", function () {
    if (swiper.isEnd) {
      swiper.autoplay = false;
    }
  });
}

const startTimer = function () {
  const tick = function () {
    const min = String(Math.trunc(time / 60)).padStart(2, 0);
    const sec = String(time % 60).padStart(2, 0);

    document.getElementById("timer").innerHTML = `${min}:${sec}`;
    if (time === 0) {
      clearInterval(timer);
      document.getElementById("timer").innerHTML = "Time's up!";
      endResult();
    }

    time--;
  };
  let time = timerSec;

  tick();
  const timer = setInterval(tick, 1000);
  return timer;
};
startTimer();

</script>
@endpush