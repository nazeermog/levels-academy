@extends("student.layouts.dashboard")
@push('css')
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous"
    />
    <style>
            body {
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        }

        .abacus {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        }

        #abacus {
        display: flex;
        justify-content: center;
        position: relative;
        }
        #abacus::after {
        content: "";
        width: 15px;
        border-radius: 100px 100px 75px 75px;
        height: 100%;
        background: #878687;
        position: absolute;
        left: -45px;
        }
        #abacus::before {
        content: "";
        width: 15px;
        border-radius: 100px 100px 75px 75px;
        height: 100%;
        background: #878687;
        position: absolute;
        right: -45px;
        }

        .stander {
        width: calc(100% + 90px);
        border-radius: 100px 100px 75px 75px;
        height: 15px;
        background: #878687;
        position: relative;
        }
        .stander:first-child {
        position: absolute;
        top: 0;
        z-index: 111;
        }
        .stander:last-child {
        position: absolute;
        bottom: 0;
        z-index: 111;
        }

        .rods {
        display: flex;
        flex-direction: row-reverse;
        height: 205px;
        width: 100%;
        }

        [dir=rtl] .rods {
        flex-direction: unset;
        }

        .one-rod:not(:last-child) {
        margin-left: 30px;
        }

        .rod-top {
        height: 70px;
        position: relative;
        }
        .rod-top .rod {
        display: flex;
        flex-direction: column;
        background: #878687;
        align-items: center;
        padding: 0 5px;
        width: 10px;
        height: 100%;
        }
        .rod-top .beads {
        display: flex;
        flex-direction: column;
        justify-content: end;
        height: 100%;
        padding: 15px 0;
        padding-bottom: 10px;
        }
        .rod-top .bead-top {
        width: 30px;
        height: 20px;
        background: #489fb7;
        border-radius: 20%;
        transition: margin-bottom 0.5s;
        box-shadow: inset 0 -10px 10px -10px #000000, inset 0px 0px 2px rgba(0, 0, 0, 0.5);
        margin-bottom: 25px;
        }
        .rod-top .bead-top.active {
        margin-bottom: 0px;
        }
        .rod-top::before {
        content: "";
        width: 70px;
        height: 10px;
        background-color: #878687;
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        }

        .rod-bottom {
        height: 135px;
        }
        .rod-bottom .rod {
        display: flex;
        flex-direction: column;
        background: #878687;
        align-items: center;
        padding: 0 5px;
        width: 10px;
        height: 100%;
        }
        .rod-bottom .beads {
        display: flex;
        flex-direction: column;
        justify-content: end;
        height: 100%;
        padding: 15px 0;
        padding-top: 0;
        }
        .rod-bottom .bead-down {
        width: 30px;
        height: 20px;
        background: #489fb7;
        border-radius: 20%;
        box-shadow: inset 0 -10px 10px -10px #000000, inset 0px 0px 2px rgba(0, 0, 0, 0.5);
        transition: margin-bottom 0.5s;
        }
        .rod-bottom .bead-down.active {
        margin-bottom: 40px;
        }

        /*# sourceMappingURL=main.css.map */

    </style>
    <link rel="stylesheet" href="./assets/style/style.css"/>
@endpush
@section("content")

<div class="container pt-5 input-section">
      <div class="row">
        <div class="col-sm-4 mx-auto text-center">
          <p>Enter the number of columns</p>
          <input type="number" class="form-control" id="rodsNumber" />
          <button class="btn btn-secondary mt-2" id="start-game">Start</button>
        </div>
      </div>
    </div>
    <div class="abacus d-none">
      <p id="feedback" class="fs-4 text-success fw-bold"></p>
      @php
        $first=true;
      @endphp
      <h1 style="direction:ltr;"> @foreach ($randomNumbers as $num)
        @if (!$first)
          {{' + '}}
        @else
        @php
        $first=false;
        @endphp
        @endif
       {{$num}}
      @endforeach
      </h1>

      <div id="abacus">
        <div class="stander"></div>
        <div class="rods"></div>
        <div class="stander"></div>
        
        <!-- <button class="btn btn-primary">submit</button> -->
      </div>
      <div class="submit mt-4 text-center" id="submit">
        <div class="d-block mb-2">
          <button class="btn btn-secondary ms-3 d-none" id="nextStep" disabled>
            Show Result
          </button>
          <button class="btn btn-secondary d-none" id="prevStep" disabled>
            Prev
          </button>
        </div>
        <button class="btn btn-primary" id="submit">Submit</button>
        <!-- <button class="btn btn-primary ms-3 d-none" id="showResult">
          Show Result
        </button> -->
      </div>
    </div>
   

@endsection

@push('js')
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous">

</script>


<script>
const data = [
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
];
// const result = [
//   [0, 1, 1, 1, 0],
//   [0, 0, 0, 0, 0],
//   [0, 0, 0, 0, 0],
//   [0, 0, 0, 0, 0],
// ];

// const step1Php=stepsPhp[0];
// const step2Php=stepsPhp[1];
// const step3Php=stepsPhp[2];
// const step4Php=stepsPhp[3];

// console.log(step1Php);
// console.log(step2Php);
// console.log(step3Php);
// console.log(step4Php);

// const steps = [step1Php, step2Php, step3Php, step4Php];

const randoms = <?php echo json_encode($randomNumbers); ?>;
console.log(randoms);

// const stepsPhp = <?php echo json_encode($results); ?>;
// console.log(stepsPhp);

const steps = [];
let lastStepResult;
<?php foreach ($results as $index => $result): ?>
  const stepPhp<?= $index ?> = <?= json_encode($result) ?>;
  lastStepResult = stepPhp<?= $index ?>;
  // const randomForStep<?= $index ?> = randoms[<?= $index ?>];
  // console.log( randomForStep<?= $index ?>);
  console.log(stepPhp<?= $index ?>);
  steps.push(stepPhp<?= $index ?>);
<?php endforeach; ?>
const result = lastStepResult;


console.log(data.length);
const abacus = document.querySelector(".abacus");
const inputSection = document.querySelector(".input-section");
const feedback = document.querySelector("#feedback");
const nextStep = document.getElementById("nextStep");
const prevStep = document.getElementById("prevStep");
function createRod(col) {
  const rods = document.querySelector(".rods");
  const html = `<div class="one-rod">
  <div class="rod-top">
    <div class="rod">
      <div class="beads">
        <div class="bead bead-top"></div>
      </div>
    </div>
  </div>
  <div class="rod-bottom">
    <div class="rod">
      <div class="beads">
        <div class="bead bead-down"></div>
        <div class="bead bead-down"></div>
        <div class="bead bead-down"></div>
        <div class="bead bead-down"></div>
      </div>
    </div>
  </div>
</div>`;

  for (let i = 0; i < col; i++) {
    rods.insertAdjacentHTML("afterbegin", html);
  }
}

function startGame(rodNumber) {
  abacus.classList.remove("d-none");
  inputSection.classList.add("d-none");
  createRod(rodNumber);
  const rods = document.querySelectorAll(".one-rod");
  rods.forEach((rod, index) => {
    const beadsDown = rod.querySelectorAll(".bead-down");
    const beads = rod.querySelectorAll(".bead");
    beads.forEach((bead) => {
      bead.setAttribute("data-item", "0");
    });
    beadsDown.forEach((bead, item) => {
      bead.addEventListener("click", function () {
        const currentValue = Number(this.getAttribute("data-item"));
        const beadsDownIndex = beadsDown.length - 1;

        beadsDown.forEach((bead) => {
          bead.setAttribute("data-item", "0");
          bead.classList.remove("active");
        });
        if (item != 0) {
          bead.classList.add("active");
          for (let i = item; i >= 0; i--) {
            beadsDown[i].setAttribute("data-item", "1");
          }
        } else {
          if (currentValue === 0) {
            this.setAttribute("data-item", "1");
            this.classList.add("active");
          } else {
            this.setAttribute("data-item", "0");
            this.classList.remove("active");
          }
        }
      });
    });

    const beadTop = rod.querySelector(".bead-top");
    beadTop.addEventListener("click", function () {
      const beadTopValue = Number(beadTop.getAttribute("data-item"));
      if (beadTopValue === 0) {
        this.setAttribute("data-item", "1");
        this.classList.add("active");
      } else {
        this.setAttribute("data-item", "0");
        this.classList.remove("active");
      }
    });
  });
  dataStart(data);

  function compareResult(arr1, arr2) {
    return JSON.stringify(arr1) === JSON.stringify(arr2);
  }

  const submit = document.querySelector("#submit");

  submit.addEventListener("click", function () {
    let arrResult = [];
    for (let i = 0; i < rods.length; i++) {
      const bead = rods[i].querySelectorAll(".bead");
      let subArr = [];

      for (let j = 0; j < bead.length; j++) {
        const beadValue = bead[j].getAttribute("data-item");
        subArr.push(beadValue);
      }
      subArr.reverse();
      arrResult.push(subArr.map((arr) => parseInt(arr, 10)));
    }
    if (compareResult(result, arrResult)) {
      feedback.textContent = "The answer is correct";
      feedback.classList.add("text-success");
      nextStep.disabled = false;
      nextStep.classList.remove("d-none");
    } else {
      feedback.textContent = "The answer is not correct";
      feedback.classList.add("text-danger");
      nextStep.disabled = false;
      nextStep.classList.remove("d-none");
      prevStep.classList.remove("d-none");
    }

    if (compareResult(data, result)) {
      console.log("true");
    } else {
      console.log("false");
    }
  });
}

function dataStart(dataBead) {
  const rodsContainer = document.querySelector(".rods");
  // Loop through each rod
  const rods = rodsContainer.querySelectorAll(".one-rod");
  rods.forEach((rod, index) => {
    const beads = rod.querySelectorAll(".bead");
    const beadsArr = Array.prototype.slice.call(beads);
    // Loop through each bead and update data-item value
    beadsArr.reverse().forEach((bead, i) => {
      bead.dataset.item = dataBead[index][i];
    });
    const beadDown = rod.querySelectorAll(".bead-down");
    const beadUp = rod.querySelector(".bead-top");
    const beadDownArr = Array.prototype.slice.call(beadDown);
    const test = beadDownArr.reverse().find((ele) => ele.dataset.item == 1);
    if (test) {
      test.classList.add("active");
    }
    if (beadUp.dataset.item == 1) {
      beadUp.classList.add("active");
    }
  });
}

const rodsNumber = document.getElementById("rodsNumber");
const startBtn = document.getElementById("start-game");
startGame(data.length);

let currentStep = 0;
// let currentIndex = 0;
// function updateData() {
//   if (currentStep < result.length) {
//     const rodsContainer = document.querySelector(".rods");
//     const rods = rodsContainer.querySelectorAll(".one-rod");

//     // let rodsDiv = rods[currentStep];
//     const beads = rods.querySelectorAll(".bead");
//     const beadsArr = Array.prototype.slice.call(beads);
//     beadsArr.reverse().forEach((bead, i) => {
//       bead.dataset.item = steps[currentStep][i];
//       console.log(steps[currentStep][i]);
//     });
//     const beadDown = rodsDiv.querySelectorAll(".bead-down");
//     const beadUp = rodsDiv.querySelector(".bead-top");
//     const beadDownArr = Array.prototype.slice.call(beadDown);
//     const test1 = beadDownArr.reverse().find((ele) => ele.dataset.item == 1);

//     if (test1) {
//       test1.classList.add("active");
//     }
//     if (beadUp.dataset.item == 1) {
//       beadUp.classList.add("active");
//     }
//     currentStep++;
//   } else {
//     console.log("endd");
//   }
// }

function updateData(dataBead) {
  const rodsContainer = document.querySelector(".rods");
  // Loop through each rod
  const rods = rodsContainer.querySelectorAll(".one-rod");
  rods.forEach((rod, index) => {
    const beads = rod.querySelectorAll(".bead");
    beads.forEach((bead) => {
      bead.classList.remove("active");
    });
    const beadsArr = Array.prototype.slice.call(beads);
    // Loop through each bead and update data-item value
    beadsArr.reverse().forEach((bead, i) => {
      bead.dataset.item = dataBead[index][i];
    });
    const beadDown = rod.querySelectorAll(".bead-down");
    const beadUp = rod.querySelector(".bead-top");
    const beadDownArr = Array.prototype.slice.call(beadDown);
    const test = beadDownArr.reverse().find((ele) => ele.dataset.item == 1);
    if (test) {
      test.classList.add("active");
    }
    if (beadUp.dataset.item == 1) {
      beadUp.classList.add("active");
    }
    beads.forEach((bead) => {
      if (bead.dataset.item == 0) {
        bead.classList.remove("active");
      }
    });
  });
}

nextStep.addEventListener("click", function () {
  if (currentStep < steps.length) {
    console.log("currentStep ++", currentStep);
    nextStep.textContent = "Next";
    updateData(steps[currentStep]);
    prevStep.disabled = false;
    if (currentStep < steps.length) {
      console.log("currentStep ++2", currentStep);
      currentStep++;
      console.log("currentStep ++3", currentStep);
    }
  }
  console.log("sena", currentStep, steps.length);
  if (currentStep === steps.length) {
    nextStep.textContent = "finish";
    console.log("end loop");
    prevStep.disabled = false;
  } else {
    nextStep.textContent = "next";
  }
});

prevStep.addEventListener("click", function () {
  if (currentStep === steps.length) {
    currentStep--;
    updateData(steps[currentStep]);
    nextStep.textContent = "next";
  }
  if (currentStep > 0 && currentStep - 1 != 0) {
    currentStep--;
    updateData(steps[currentStep]);
    nextStep.textContent = "next";
  } else if (currentStep - 1 == 0) {
    currentStep--;
    updateData(steps[currentStep]);
    currentStep++;
    nextStep.textContent = "next";
  } else {
    console.log("rere");
  }
});
</script>
@endpush
