const data = [
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
];
const result = [
  [1, 1, 1, 1, 1],
  [1, 1, 1, 1, 1],
  [1, 1, 1, 1, 1],
  [1, 1, 1, 1, 1],
];
const step1 = [
  [0, 1, 1, 1, 1],
  [0, 1, 1, 1, 1],
  [0, 1, 1, 1, 1],
  [0, 1, 1, 1, 1],
];
const step2 = [
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
];
const step3 = [
  [0, 0, 0, 1, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [1, 0, 0, 0, 0],
];
const step4 = [
  [0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0],
  [0, 0, 1, 0, 0],
  [0, 0, 0, 0, 1],
];

const steps = [step1, step2, step3, step4];

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

// startBtn.addEventListener("click", function () {
//   startGame(rodsNumber.value);
//   if (data.length > 0) {
//     setTimeout(() => {
//       dataStart();
//     }, 100);
//   }
// });
