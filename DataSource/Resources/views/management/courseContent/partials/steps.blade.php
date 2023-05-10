@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />

    <style>
        .droppable-area2,
        .droppable-area3 {
            min-height: 100px;
        }

        .accordion-body {
            padding: 0;
        }

        .draggable-item {
            padding: .5rem;
        }

        .draggable-item:not(:last-child) {
            border-bottom: 1px solid #f7f7f7;
        }

        .draggable-item h4 {
            margin-bottom: 0;
        }

        .cursor-pointer {
            cursor: pointer;
        }


        .cards .box.selected {
            border-color: green;
        }
    </style>
@endpush

<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <button class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#addBox">
                Add Step
            </button>
        </div>
        <div class="col-md-5">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <span class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Lessons
                        </span>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                        <div class="accordion-body">
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0" id="list1">
                                @foreach ($lessons as $lesson)

                                    <li class="draggable-item cursor-pointer" data-id="list1" id="{{ $lesson->id }}">
                                        <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                            <h4>{{ $lesson->title }}</h4>
                                            <i class="bi bi-chevron-double-right move-btn"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Practices
                        </span>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                        <div class="accordion-body">
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0" id="list2">
                                @foreach ($practices as $practice)
                                    <li class="draggable-item cursor-pointer" data-id="list2" id="{{ $practice->id }}">
                                        <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                            <h4>{{ $practice->title }}</h4>
                                            <i class="bi bi-chevron-double-right move-btn"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree" id="list3">
                        <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Quizzes
                        </span>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                        <div class="accordion-body">
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0">
                                <li class="draggable-item cursor-pointer" data-id="1" data-type="Quizzes">
                                    <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                        <h4>Task5</h4>
                                        <i class="bi bi-chevron-double-right move-btn"></i>
                                    </div>
                                </li>
                                <li class="draggable-item cursor-pointer" data-id="2" data-type="Quizzes">
                                    <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                        <h4>Task6</h4>
                                        <i class="bi bi-chevron-double-right move-btn"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="cards">
                <div class="card box mb-3" onclick="selectBox()">
                    <div class="card-body">
                        <div class="border-bottom d-flex justify-content-between">
                            <div class="box-information">
                                <h6>Title</h6>
                                <p>Description</p>
                            </div>
                            <div class="">
                                <button class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#editBox"
                                    onclick="openUpdateInfo();">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </div>
                        </div>
                        <ul class="list-unstyled connected-sortable droppable-area2 mb-0 p-0"></ul>
                    </div>
                </div>
                <div class="card box mb-3" onclick="selectBox()">
                    <div class="card-body">
                        <div class="border-bottom d-flex justify-content-between">
                            <div class="box-information">
                                <h6>Title1</h6>
                                <p>Description1</p>
                            </div>
                            <div class="">
                                <button class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#editBox"
                                    onclick="openUpdateInfo();">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </div>
                        </div>
                        <ul class="list-unstyled connected-sortable droppable-area2 mb-0 p-0"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Box -->
<div class="modal fade" id="addBox" tabindex="-1" aria-labelledby="addBoxLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBoxLabel">Add Step</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="title" class="form-control mb-3" id="title" />
                <textarea placeholder="Description" class="form-control" id="description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="add-box">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Box -->
<div class="modal fade" id="editBox" tabindex="-1" aria-labelledby="addBoxLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBoxLabel">Edit box</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="title" class="form-control mb-3" id="editTitle" />
                <textarea placeholder="Description" class="form-control" id="editDescription"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="edit-box">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        const addBox = document.querySelector("#add-box");
        const editBox = document.querySelector("#edit-box");
        // const OpeneditBox = document.querySelectorAll(".edit-btn");
        const myCards = document.querySelector(".cards");
        const submit = document.getElementById("submitForm");
        const moveItemBtn = document.querySelectorAll(".move-btn");

        $(document).ready(function() {
            $(".move-btn").click(function() {
                setTimeout(function() {
                    var selectBox = $(".box.selected .droppable-area2");
                    var itemSelect = $(" .droppable-area1 li.selected");

                    if (selectBox.length) {
                        itemSelect.clone().appendTo(selectBox);
                        var itemCopyed = $(".droppable-area2 li.selected");
                        var btnIcon = $(" .droppable-area2 li.selected i");
                        $(btnIcon)
                            .addClass("bi bi-trash text-danger delete")
                            .removeClass("bi bi-chevron-double-right move-btn");
                        $(itemCopyed).on("click", function() {
                            $(this).remove();
                        });
                    } else {
                        alert("choose the box");
                    }
                }, 20);
            });

            $(".droppable-area1").on("click", "li", function() {
                $(".droppable-area1 li").removeClass("selected");
                $(this).addClass("selected");
            });
        });

        var modal = new bootstrap.Modal("#addBox", {
            hide: true,
        });

        var modaledit = new bootstrap.Modal("#editBox", {
            hide: true,
        });
        let cards = [];

        function init() {
            const boxes = myCards.querySelectorAll(".box");
            cards = boxes;
        }

        init();
        setTimeout(selectBox, 10);

        function selectBox() {
            cards.forEach(function(item, index) {
                item.addEventListener("click", function() {
                    cards.forEach(function(item) {
                        item.classList.remove("selected");
                    });
                    this.classList.add("selected");
                });
            });
        }

        function addBoxs() {
            const title = document.getElementById("title");
            const description = document.getElementById("description");
            myCards.innerHTML += `
                <div class="card box mb-3" onclick="selectBox()">
                    <div class="card-body">
                    <div class="border-bottom d-flex justify-content-between">
                    <div class="box-information">
                        <h6>${title.value}</h6>
                        <p>${description.value}</p>
                    </div>
                    <div>
                        <button
                        class="btn edit-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#editBox" onclick="openUpdateInfo()">
                        <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    </div>
                    <ul class="list-unstyled connected-sortable droppable-area2 mb-0 p-0">
                    </ul>
                    </div>
                    </div>
      `;
            // updateModal();
            title.value = "";
            description.value = "";
        }

        let modalsEidt = [];

        function updateModal() {
            const OpenediwtBox = document.querySelectorAll(".edit-btn");
            modalsEidt = OpenediwtBox;
        }
        updateModal();

        addBox.addEventListener("click", function(event) {
            event.preventDefault();
            addBoxs();
            modal.hide();
            init();
            selectBox();
            updateModal();
            openUpdateInfo();
        });

        function editBoxe() {
            setTimeout(() => {
                const editTitle = document.getElementById("editTitle");
                const editDescription = document.getElementById("editDescription");
                const titleValue = document.querySelector(
                    ".box.selected .box-information h6"
                );
                const descriptionValue = document.querySelector(
                    ".box.selected .box-information p"
                );
                editTitle.value = titleValue.innerHTML;
                editDescription.value = descriptionValue.innerHTML;
            }, 200);
        }

        function updateInformation() {
            setTimeout(() => {
                const editTitle = document.getElementById("editTitle");
                const editDescription = document.getElementById("editDescription");
                const titleValue = document.querySelector(
                    ".box.selected .box-information h6"
                );
                const descriptionValue = document.querySelector(
                    ".box.selected .box-information p"
                );
                titleValue.textContent = editTitle.value;
                descriptionValue.textContent = editDescription.value;
            }, 200);
        }

        setTimeout(openUpdateInfo, 10);

        function openUpdateInfo() {
            modalsEidt.forEach(function(box) {
                box.addEventListener("click", function() {
                    editBoxe();
                });
            });
        }

        editBox.addEventListener("click", function() {
            updateInformation();
            modaledit.hide();
        });
        submit.addEventListener('click', function() {
            const boxArr = []
            const card = document.querySelectorAll('.card');
            card.forEach(function(item, index) {
                const title = item.querySelector('h6');
                const desc = item.querySelector('p');
                const tasks = item.querySelectorAll('.draggable-item');
                console.log("taaaaa", tasks);


                boxArr.push({
                    'title': title.innerHTML,
                    'desc': desc.innerHTML,
                    'type': [],
                })

                tasks.forEach((task, i) => {
                    const taskId = task.getAttribute(['data-id']);
                    const taskType = task.getAttribute(['data-type']);

                    boxArr.forEach((box, inx) => {
                        console.log(index, inx);
                        if (index === inx) {
                            box.type.push({
                                'id': taskId,
                                'type': taskType,
                            })
                        }
                    })
                })
            })

            console.log('boxArr =>', boxArr);
        })
    </script>
@endpush
