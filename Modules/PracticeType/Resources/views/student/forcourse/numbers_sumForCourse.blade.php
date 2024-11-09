@extends("student.layouts.dashboard")
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
        margin: 0;
        padding: 0;
        background-color: #bdcdd6;
        }

        .cards {
        position: relative;
        height: 100vh;
        }

        .cards .card {
        background-color: #93bfcf;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        width: 250px;
        height: 350px;
        margin: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 20px;
        }

        .cards .card {
        color: #ffffff;
        font-size: 2.5rem;
        }

        html,
        body {
        position: relative;
        height: 100%;
        }

        body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
        }

        .swiper {
        width: 270px;
        height: 350px;
        }

        .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 22px;
        font-weight: bold;
        color: #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        background-color: #fff;
        color: #489fb7;
        }

        #form {
        display: flex;
        flex-direction: column;
        max-width: 300px;
        margin: auto;
        }
        #form input {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #000;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #dbdbdb;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 10px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .swiper-slide {
        font-size: 42px;
        }
        body {
        margin: 0;
        padding: 0;
        background-color: #bdcdd6;
        }

        .cards {
        position: relative;
        height: 100vh;
        }

        .cards .card {
        background-color: #93bfcf;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        width: 250px;
        height: 350px;
        margin: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 20px;
        }

        .cards .card {
        color: #ffffff;
        font-size: 2.5rem;
        }

        html,
        body {
        position: relative;
        height: 100%;
        }

        body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
        }

        .swiper {
        width: 270px;
        height: 350px;
        }

        .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 22px;
        font-weight: bold;
        color: #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        background-color: #fff;
        color: #489fb7;
        }

        #form {
        display: flex;
        flex-direction: column;
        max-width: 300px;
        margin: auto;
        }
        #form input {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #000;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #dbdbdb;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 10px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .swiper-slide {
        font-size: 42px;
        }
        .swiper-slide:nth-child(2n) {
        background-color: #489fb7;
        color: #fff;
        }
        /* 
        .swiper-slide:nth-child(3n) {
        background-color: #1c3352;
        }

        .swiper-slide:nth-child(4n) {
        background-color: #2b2829;
        } */
        /* 
            .swiper-slide:nth-child(5n) {
            background-color: rgb(118, 163, 12);
            }

            .swiper-slide:nth-child(6n) {
            background-color: rgb(180, 10, 47);
            }

            .swiper-slide:nth-child(7n) {
            background-color: rgb(35, 99, 19);
            }

            .swiper-slide:nth-child(8n) {
            background-color: rgb(0, 68, 255);
            }

            .swiper-slide:nth-child(9n) {
            background-color: rgb(218, 12, 218);
            }

            .swiper-slide:nth-child(10n) {
            background-color: rgb(54, 94, 77);
            } */
    </style>
@endpush
@section("content")
    <div class="vh-100 d-flex justify-content-center align-items-center" id="btnStart">
        <button class="btn btn-primary" id="startGame">Start Game</button>
    </div>
    <div class="position-relative min-vh-100 d-flex flex-column align-items-center justify-content-center d-none"
         id="gameContent">
        <div class="container">
            <div class="swiper game-slider" id="game-slider">
                <div class="swiper-wrapper"></div>
            </div>
            <div id="form" class="mt-5">
                <input class="form-control" type="text" placeholder="Enter Your Result" id="inputValue"/>
                <button class="btn btn-primary mt-2" id="sendResult">Send Result</button>
            </div>
        </div>
    </div>

@endsection
<div class="modal fade" tabindex="-1" id="you-win">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4 class="text-success">You are won.</h4>
                <button class="btn btn-danger mt-2" onclick="reloadPage()">Restart</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="you-lose">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4 class="text-danger">You lose.</h4>
                <button class="btn btn-success mt-2" onclick="reloadPage()">Restart</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
            integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
            integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.9.3/tsparticles.confetti.bundle.min.js"></script>
    <script>
        function reloadPage() {
            window.location.reload();
        };
        let sumNumber=0;
        const divBtn = document.querySelector('#btnStart');
        const btnStart = document.querySelector('#startGame');
        const gameContent = document.querySelector('#gameContent');
        const cards = document.querySelector(".game-slider .swiper-wrapper");
        const formInput = document.querySelector("#inputValue");
        const formButton = document.querySelector("#sendResult");


        btnStart.addEventListener('click', function () {
            if (gameContent.classList.contains) {
                divBtn.classList.add('d-none');
                gameContent.classList.remove('d-none');
                // Disabled Button When Input empty
                formButton.disabled = true;
                formInput.addEventListener("keyup", buttonState);

                function buttonState() {
                    if (document.querySelector("#inputValue").value === "") {
                        formButton.disabled = true;
                    } else {
                        formButton.disabled = false;
                    }
                }


                function createElement(number) {
                    const newCard = document.createElement("div");
                    newCard.classList.add("swiper-slide")
                    newCard.innerHTML = number;
                    cards.appendChild(newCard);
                }

                const arr = Array.from({
                    length: {{$practice-> card_number}}
                }, () => Math.floor(Math.random() * {{rand($practice->range_number_from, $practice->range_number_to)}}));
                console.log(arr);

                const initialValue = 0;
                 sumNumber = arr.reduce((accumulator, currentValue) => accumulator + currentValue, initialValue);

                const cardNumber = arr.length;

                const number = arr.map(a => {
                    createElement(a);
                });

                let InputElemet = document.getElementById('inputValue');

                InputElemet.addEventListener('input', function (event) {

                    var regex = new RegExp(/^([1-9][0-9]*)$/);

                    if (regex.test(InputElemet.value)) {

                        return true;

                    } else {

                        InputElemet.value = "";

                        return false;
                    }

                });
                var modalWin = new bootstrap.Modal('#you-win', {
                    show: true
                });
                var modallose = new bootstrap.Modal('#you-lose', {
                    show: true
                });

                console.log(sumNumber);
                document.querySelector("#sendResult").addEventListener('click', function prossesResult() {
                    const inputValue = parseInt(document.getElementById("inputValue").value);

                    $.ajax({
                        method: "POST",
                        url: "{{ route('student.practice.store')}}",
                        data: {
                            practice_id: {{$practice->practice_id}},
                            practice_type_id: {{$practice->id}},
                            level_title: '{{$practice->practiceLevel->title}}',
                            result_student: inputValue,
                            result_true: sumNumber,
                            student_id: {{auth()->user()->id}},
                            is_true: sumNumber === inputValue,
                            seconds_speed: {{$practice->seconds_speed}},
                            card_number: {{$practice->card_number}},
                            range_number_from: {{$practice ->range_number_from }},
                            range_number_to: {{$practice->range_number_to}}

                        },
                        success: function (one, two, three) {
                            toastr.success('updated successfully')
                        },
                        error: function (one, two, three) {
                            toastr.error('error')
                        },
                    });

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

                    console.log(inputValue);
                    if (sumNumber === inputValue) {
                        modalWin.show()
                        setTimeout(winner, 0);
                        document.getElementById("inputValue").value = '';
                    } else {
                        modallose.show();
                    }

                })


                var swiper = new Swiper(".game-slider", {
                    loop: false,
                    effect: "cards",
                    simulateTouch: false,
                    autoplay: {
                        delay: {{$practice->seconds_speed *100}},
                    stopOnLastSlide: true,
                },
            });


            const duration = 15 * 1000,
                animationEnd = Date.now() + duration,
                defaults = {
                    startVelocity: 30,
                    spread: 360,
                    ticks: 60,
                    zIndex: 2000
                };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            function winner() {
                const interval = setInterval(function() {
                    const timeLeft = animationEnd - Date.now();

                    if (timeLeft <= 0) {
                        return clearInterval(interval);
                    }

                    const particleCount = 50 * (timeLeft / duration);

                    // since particles fall down, start a bit higher than random
                    confetti(
                        Object.assign({}, defaults, {
                            particleCount,
                            origin: {
                                x: randomInRange(0.1, 0.3),
                                y: Math.random() - 0.2
                            },
                        })
                    );
                    confetti(
                        Object.assign({}, defaults, {
                            particleCount,
                            origin: {
                                x: randomInRange(0.7, 0.9),
                                y: Math.random() - 0.2
                            },
                        })
                    );
                }, 250);

            }
        }

    })
</script>
@endpush
