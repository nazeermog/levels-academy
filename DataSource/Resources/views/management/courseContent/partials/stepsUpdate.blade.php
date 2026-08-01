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

        /* --- Drag & drop ordering --- */
        .box-information { cursor: move; }
        .droppable-area2 li { cursor: move; }
        .box-placeholder {
            border: 2px dashed #bbb;
            background: #fafafa;
            border-radius: .25rem;
            margin-bottom: 1rem;
            min-height: 90px;
        }
        .item-placeholder {
            border: 2px dashed #bbb;
            background: #fafafa;
            border-radius: .25rem;
            margin: .5rem;
            min-height: 44px;
            list-style: none;
        }
        .drag-hint { font-size: .8rem; color: #888; }
    </style>
@endpush

<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#addBox">
                Add Step
            </button>
            <!-- <button type="button" class="btn btn-primary mb-3" id="testArr">
                test
            </button> -->
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

                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                        <div class="accordion-body">
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0" >
                                @foreach ($lessons as $lesson)
                                    <li class="draggable-item cursor-pointer" data-id="{{ $lesson->id }}" id="{{ $lesson->id }}" data-type="Lessons">
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
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0">
                            @foreach ($practices as $practice) 
                                    <li class="draggable-item cursor-pointer" data-id="{{ $practice->id }}"
                                        id="{{  $practice->id }}" data-type="Practices"
                                        ordering="{{ $loop->iteration }}">
                                        <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                            <!-- this is a practice details -->
                                            <h4>{{ $practice->practice->title.' : '.$practice->title }}</h4>
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
                <!-- Class Sessions source (used by classroom-type steps) -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSessions">
                        <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSessions" aria-expanded="false" aria-controls="collapseSessions">
                            Class Sessions
                        </span>
                    </h2>
                    <div id="collapseSessions" class="accordion-collapse collapse" aria-labelledby="headingSessions">
                        <div class="accordion-body">
                            <div class="p-2">
                                <select id="sessionInstructorFilter" class="form-select form-select-sm mb-2">
                                    <option value="">All instructors</option>
                                    @foreach ($instructors as $ins)
                                        <option value="{{ $ins->user_id }}">{{ $ins->first_name }} {{ $ins->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0" id="sessionsList">
                                @foreach ($sessions as $session)
                                    <li class="draggable-item cursor-pointer session-item" data-id="{{ $session->id }}"
                                        id="session-{{ $session->id }}" data-type="ClassSessions"
                                        data-instructor-id="{{ $session->instructor_id }}">
                                        <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                            <h4>
                                                {{ optional($session->classroom)->name ?? 'Session' }}@if($session->content) — {{ Str::limit($session->content, 40) }}@endif
                                                <small class="text-muted d-block">
                                                    @if($session->held_at)<span data-localtime="{{ $session->held_at->toIso8601String() }}">{{ $session->held_at->format('Y-m-d H:i') }} UTC</span>@endif ·
                                                    {{ optional($session->instructor)->first_name }} {{ optional($session->instructor)->last_name }}
                                                </small>
                                            </h4>
                                            <i class="bi bi-chevron-double-right move-btn"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Worksheets source (PDF/Word — can be added to ANY step type) -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingWorksheets">
                        <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseWorksheets" aria-expanded="false" aria-controls="collapseWorksheets">
                            Worksheets
                        </span>
                    </h2>
                    <div id="collapseWorksheets" class="accordion-collapse collapse" aria-labelledby="headingWorksheets">
                        <div class="accordion-body">
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0" id="worksheetsList">
                                @foreach ($worksheets as $worksheet)
                                    <li class="draggable-item cursor-pointer" data-id="{{ $worksheet->id }}"
                                        id="worksheet-{{ $worksheet->id }}" data-type="Worksheets">
                                        <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                            <h4>{{ $worksheet->title }}</h4>
                                            <i class="bi bi-chevron-double-right move-btn"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Links source (saved URLs — can be added to ANY step type; or use "Add Link" to create one) -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingLinks">
                        <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseLinks" aria-expanded="false" aria-controls="collapseLinks">
                            Links
                        </span>
                    </h2>
                    <div id="collapseLinks" class="accordion-collapse collapse" aria-labelledby="headingLinks">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-sm btn-info" id="addLinkBtn">+ Add new link</button>
                            </div>
                            <ul class="list-unstyled connected-sortable droppable-area1 mb-0" id="linksList">
                                @foreach ($links as $link)
                                    <li class="draggable-item cursor-pointer" data-id="{{ $link->id }}"
                                        id="link-{{ $link->id }}" data-type="Links" data-url="{{ $link->url }}">
                                        <div class="d-flex align-items-center justify-content-between border px-3 py-2">
                                            <h4>{{ $link->title }}</h4>
                                            <i class="bi bi-chevron-double-right move-btn"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
    <p class="drag-hint mb-2">Drag a step by its title to reorder steps &middot; drag items inside a step to reorder them.</p>
    <div class="cards">
        @foreach ($item->courseContents as $content)
        <div class="card box mb-3" onclick="selectBox()" data-box-id="{{ $content->id }}" data-box-title="{{ $content->title }}" data-box-desc="{{ $content->desc }}" data-step-type="{{ $content->step_type }}">
            <div class="card-body">
                <div class="border-bottom d-flex justify-content-between">
                    <div class="box-information">
                        <h6>{{$content->title}}</h6>
                        <p>{{$content->desc}}</p>
                    </div>
                    <div class="">
                        <button class="btn edit-btn" data-bs-toggle="modal" data-bs-target="#editBox" onclick="openUpdateInfo();">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
                <ul class="list-unstyled connected-sortable droppable-area2 mb-0 p-0">
                    @foreach ($content->courseSteps as $step)
                    {{-- data-id MUST be the stepable_id (lesson/practice/session id), not the course_step id —
                         the save handler stores this value straight into course_steps.stepable_id. --}}
                    <li class="draggable-item d-flex align-items-center justify-content-between border px-3 py-2 m-2 mt-3" data-id="{{ $step->stepable_id }}" data-type="{{ $step->stepable_type }}" @if($step->stepable_type === 'Links') data-url="{{ optional($step->link)->url }}" @endif ordering="{{ $step->ordering }}">
                        <h4>{{ $step->title }}</h4>
                        <i class="bi-trash text-danger delete" onclick="removeStep(this)"></i>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
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
                <textarea placeholder="Description" class="form-control mb-3" id="description"></textarea>
                <label class="form-label">Step type</label>
                <select id="stepType" class="form-select">
                    <option value="normal">Normal (lessons / practices)</option>
                    <option value="classroom">Classroom (class sessions)</option>
                </select>
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
                <textarea placeholder="Description" class="form-control mb-3" id="editDescription"></textarea>
                <label class="form-label">Step type</label>
                <select id="editStepType" class="form-select">
                    <option value="normal">Normal (lessons / practices)</option>
                    <option value="classroom">Classroom (class sessions)</option>
                </select>
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


<!-- Add Link -->
<div class="modal fade" id="addLinkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Link to selected step</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="Link title" class="form-control mb-3" id="linkTitle" />
                <input type="url" placeholder="https://..." class="form-control mb-2" id="linkUrl" />
                <small class="text-muted">Select a step (box) first, then add the link into it. Students who click it get it marked complete.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveLinkBtn">Add</button>
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
                        var boxType = $(".box.selected").attr('data-step-type') || 'normal';
                        var itemType = itemSelect.attr('data-type');
                        var isSession = itemType === 'ClassSessions';
                        var isWorksheet = itemType === 'Worksheets';
                        var isLink = itemType === 'Links';
                        // Worksheets & links may be added to ANY step type; class sessions only to classroom steps.
                        if (boxType === 'classroom' && !isSession && !isWorksheet && !isLink) {
                            alert('Classroom steps can only contain class sessions, worksheets or links.');
                            return;
                        }
                        if (boxType !== 'classroom' && isSession) {
                            alert('Class sessions can only be added to classroom steps.');
                            return;
                        }
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

            initSortables();
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

                const boxId = this.getAttribute('data-box-id');
                const boxDesc = this.getAttribute('data-box-desc');

                console.log('Box ID:', boxId);
                console.log('Box Description:', boxDesc);
            });
        });
    }
    function removeStep(iconElement) {
    const stepItem = iconElement.parentElement;
    stepItem.remove();
}

        function addBoxs() {
            const title = document.getElementById("title");
            const description = document.getElementById("description");
            const stepType = document.getElementById("stepType");
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
            const newBox = myCards.lastElementChild;
            if (newBox) { setBoxStepType(newBox, stepType.value); }
            // updateModal();
            title.value = "";
            description.value = "";
            stepType.value = "normal";
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
            initSortables();
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
                const selectedBox = document.querySelector(".box.selected");
                document.getElementById("editStepType").value = getBoxStepType(selectedBox);
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
                const selectedBox = document.querySelector(".box.selected");
                setBoxStepType(selectedBox, document.getElementById("editStepType").value);
            }, 200);
        }

        setTimeout(openUpdateInfo, 10);

        function openUpdateInfo() {
            modalsEidt.forEach(function(box) {
                event.preventDefault();
                box.addEventListener("click", function() {
                    editBoxe();
                });
            });
        }

        editBox.addEventListener("click", function() {
            updateInformation();
            modaledit.hide();
        });
        // --- Drag & drop ordering -----------------------------------------
        // Steps (boxes) can be reordered by dragging their title area, and the
        // items inside a box can be reordered. The save handler already reads
        // `ordering` from DOM position, so dragging is all that's needed.
        function initSortables() {
            if (!window.jQuery || !$.fn.sortable) { return; }

            $(".cards").sortable({
                items: "> .box",
                handle: ".box-information",
                axis: "y",
                distance: 5,
                tolerance: "pointer",
                placeholder: "box-placeholder",
                forcePlaceholderSize: true
            });

            $(".droppable-area2").sortable({
                distance: 5,
                tolerance: "pointer",
                placeholder: "item-placeholder",
                forcePlaceholderSize: true
            });
        }

        // --- Classroom step helpers ---------------------------------------
        function getBoxStepType(card) {
            return (card && card.getAttribute('data-step-type') === 'classroom') ? 'classroom' : 'normal';
        }

        function setBoxStepType(card, type) {
            if (!card) { return; }
            type = (type === 'classroom') ? 'classroom' : 'normal';
            card.setAttribute('data-step-type', type);
            const info = card.querySelector('.box-information');
            if (!info) { return; }
            let badge = info.querySelector('.step-type-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'badge step-type-badge';
                info.appendChild(badge);
            }
            badge.textContent = (type === 'classroom') ? 'Classroom' : 'Normal';
            badge.classList.toggle('bg-warning', type === 'classroom');
            badge.classList.toggle('bg-secondary', type !== 'classroom');
        }

        // Show a badge on every box already on the page.
        document.querySelectorAll('.cards .box').forEach(function (card) {
            setBoxStepType(card, getBoxStepType(card));
        });

        // Filter the Class Sessions source list by instructor.
        const sessionFilter = document.getElementById('sessionInstructorFilter');
        if (sessionFilter) {
            sessionFilter.addEventListener('change', function () {
                const val = this.value;
                document.querySelectorAll('#sessionsList .session-item').forEach(function (li) {
                    const match = !val || li.getAttribute('data-instructor-id') === val;
                    li.style.display = match ? '' : 'none';
                });
            });
        }

        // --- Inline link creation -----------------------------------------
        var linkModal = new bootstrap.Modal("#addLinkModal", { hide: true });
        var addLinkBtn = document.getElementById('addLinkBtn');
        if (addLinkBtn) {
            addLinkBtn.addEventListener('click', function () {
                if (!document.querySelector('.box.selected')) { alert('Select a step (box) first.'); return; }
                document.getElementById('linkTitle').value = '';
                document.getElementById('linkUrl').value = '';
                linkModal.show();
            });
        }
        var saveLinkBtn = document.getElementById('saveLinkBtn');
        if (saveLinkBtn) {
            saveLinkBtn.addEventListener('click', function () {
                var box = document.querySelector('.box.selected .droppable-area2');
                if (!box) { alert('Select a step (box) first.'); return; }
                var title = document.getElementById('linkTitle').value.trim();
                var url = document.getElementById('linkUrl').value.trim();
                if (!title || !url) { alert('Enter a title and a URL.'); return; }
                var li = document.createElement('li');
                li.className = 'draggable-item d-flex align-items-center justify-content-between border px-3 py-2 m-2 mt-3';
                li.setAttribute('data-id', '');
                li.setAttribute('data-type', 'Links');
                li.setAttribute('data-url', url);
                li.innerHTML = '<h4></h4><i class="bi bi-trash text-danger delete" style="cursor:pointer;"></i>';
                li.querySelector('h4').textContent = title;   // safe text (no HTML injection)
                li.querySelector('i').addEventListener('click', function () { li.remove(); });
                box.appendChild(li);
                linkModal.hide();
            });
        }

        submit.addEventListener('click', function() {
            const boxArr = [];
            const card = document.querySelectorAll('.card');

            card.forEach(function(item, index) {
                const title = item.querySelector('h6');
                const content_id = item.querySelector('h6');
                const desc = item.querySelector('p');
                const tasks = item.querySelectorAll('.draggable-item');

                const boxData = {
                    'title': title.innerHTML,
                    'desc': desc.innerHTML,
                    'step_type': item.getAttribute('data-step-type') || 'normal',
                    'type': [],
                    'ordering': index + 1,
                };

                tasks.forEach((task, i) => {
                    const taskId = task.getAttribute('data-id');
                    const taskType = task.getAttribute('data-type');
                    const taskTitle = (task.querySelector('h4').textContent || '').replace(/\s+/g, ' ').trim();
                    const taskOrdering = task.getAttribute('ordering');

                    boxData.type.push({
                        'id': taskId,
                        'type': taskType,
                        'title': taskTitle,
                        'url': task.getAttribute('data-url') || null,
                        'ordering': i + 1,
                    });
                });

                boxArr.push(boxData);
            });

            document.getElementById('boxArr').value = JSON.stringify(boxArr);
            // The surrounding <form> submits normally — its action decides where the
            // save goes (admin course update, or the instructor's own-course update).
        });
    </script>
@endpush
