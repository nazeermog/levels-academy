# Project Features By Role

This inventory was built from the route files and controllers in `DataSource\Http\Controllers`, `Modules\*\Http\Controllers`, `app\Http\Controllers\Api`, `app\Http\Middleware`, `config\features.php`, and the role/organization seeders.

## Roles Found In The Code

- `super_admin`
- `admin`
- `instructor`
- `student`
- `parentt`
- Guest/public users have no stored role, but have public pages and auth routes.
- External API consumers authenticate with Laravel Passport tokens (`auth:api`) rather than a session; a self-registered API account is created with the `student` role.

## Feature Flags & Master Switches

- `config('features.organizations')` (env `FEATURES_ORGANIZATIONS`, default `false`) is the master switch for the whole multi-tenant/organization system.
  - When **OFF** (current default): admins behave globally ("sees everything" mode). `admin` and `super_admin` both get the full global catalog, the global dashboard, and the classroom/session/report/free-session screens. The organization menu group is hidden in both the management and instructor sidebars.
  - When **ON**: the global catalog/dashboard becomes `super_admin`-only and `admin` users are scoped back to organization screens (the original behaviour).
  - No code is deleted when the flag is off — organization management routes stay registered (still `super_admin`-only) but are hidden from the UI, so flipping the flag restores the org experience.
  - The route guard is chosen by `$catalogGuard = config('features.organizations') ? 'role:super_admin' : 'role:super_admin,admin'` in `DataSource\Routes\web.php`.

## Super Admin

### Features

- Global admin dashboard with counts for practice types, practice details, result practices, courses, categories, course paths, lessons, instructors, students, semesters, parents, book exercises, products, orders, and blogs.
- Full CRUD management for organizations:
  - Organization name.
  - Subdomain.
  - Theme CSS path.
  - Active status.
- Full CRUD management for learning content:
  - Courses/course content.
  - Course steps built from lessons and practice types.
  - Course paths.
  - Lessons.
  - Categories/taxonomies.
  - Semesters.
  - Enrollments.
- Full CRUD management for practice content:
  - Practice types.
  - Practice type details.
  - Practice levels.
  - Book exercises.
- Full CRUD management for users and people:
  - Students.
  - Instructors.
  - Parents.
  - Student dashboard tiles with totals for students, courses, parents, enrollments, completed enrollments, and ongoing enrollments.
  - CSV student import with generated passwords and downloadable manager CSV.
- Store/product management:
  - Product categories.
  - Products with translated names/descriptions, photo, price, and unit.
  - Orders.
  - Approve orders.
  - Reject orders and zero their price.
  - Update order status between `pending`, `approved`, and `rejected`.
- Blog management:
  - Create/update translated blog title and description.
  - Upload/update blog photo.
  - List/show/delete blogs through resource routes.
- Result practice reporting:
  - Filter by search, student, practice, level, date range, and correct/incorrect status.
  - Show total attempts, correct answers, incorrect answers, and percentages.
- Instructor notes:
  - View all instructor notes globally.
- Free trial session waiting list:
  - View pending free-session requests (the waiting list) and recently scheduled requests.
  - Open an assignment form that lists every instructor's open, future availability slots.
  - Assign a pending request to an instructor's available slot, which:
    - Creates a free `ClassSession` (`type = free`) with the requesting user as the attendee.
    - Locks and marks the chosen availability slot as `booked` (row lock prevents double booking).
    - Marks the request `scheduled` and links instructor, slot, and session.
    - Queues an ICS calendar invite email to the requesting user after the response commits.
- User event audit:
  - View user events.
  - Filter events by user, event type, and role.
- Authentication:
  - Can log in from any organization subdomain.
  - Logs login/logout events.

### Organization Scope

- `super_admin` is global and is not limited by `organization_id`.
- When `features.organizations` is off, `admin` users share the entire Super Admin global catalog/dashboard listed above; when on, that catalog is restricted to `super_admin`.
- The free-session waiting list (`admin/free-sessions`) is available to both `super_admin` and `admin` regardless of the organizations flag.
- `User::hasRoles()` lets `super_admin` pass every role check.
- Organization login checks do not block `super_admin`.
- This role can create, edit, and delete organizations and can manage global catalog/content data used by organizations.

## Organization Admin

> Status: the organization system is currently disabled via `config('features.organizations') = false`. While off, `admin` users do **not** see the organization dashboard/users/settings menu and instead operate globally with the full Super Admin catalog. The organization-scoped routes and controllers below remain registered and become active again when the flag is turned on. The classroom, session-type, report, and free-session screens stay available to admins in both modes (they are now organization-agnostic when the flag is off).

### Features

- Organization dashboard:
  - Count users in the current organization.
  - Count students in the current organization.
  - Count instructors in the current organization.
- Organization users:
  - List users scoped to the current organization.
- Classrooms:
  - List organization classrooms.
  - Create classrooms with name, repeats per week, instructor, session type, days of week, session time, and enrolled students.
  - Edit classrooms and enrolled students.
  - Delete classrooms.
- Session types:
  - List organization session types.
  - Create session types with name, student price, and teacher payout.
  - Edit session type price/payout.
  - Delete session types.
- Absence management:
  - View absence requests.
- Organization settings:
  - Configure `absence_free_hours`, the window used to auto-approve or reject parent absence requests.
- Classroom reports (only count `normal` sessions; free trial sessions are excluded):
  - Instructor totals by month, instructor, classroom, and session type.
  - Profit report comparing session revenue and instructor payouts.
  - Student dues report showing charges, credits, net dues, and transaction counts.
  - Expected earnings report projecting revenue, payout, and profit from classroom schedules.
  - Instructor payout is computed per student: `teacher_payout × number of students billed for the session` (mirrors revenue, which charges full price per student), not divided across students. The billed count comes from this month's charge transactions referencing `Class session #<id>`, falling back to the classroom's currently-enrolled students.
- Instructor notes:
  - View notes for the organization when the current organization subdomain is `yasmine`.

### Organization Scope

- The current organization is resolved from the request subdomain by `OrganizationResolver`.
- Login blocks non-super-admin users when their `organization_id` does not match the current subdomain organization.
- Organization admin routes use `role:admin`.
- Classroom, session type, dashboard, users, settings, and report controllers scope data to `currentOrganization` where applicable.
- The classroom/session-type/report sidebar block is now shown to every `admin` and `super_admin` (no longer gated to the `yasmine` subdomain); the organization-only block (org dashboard/users/settings/instructor-notes/organizations) is gated behind `config('features.organizations')`.
- The organization-scoped controllers still resolve `currentOrganization` where applicable, but with organizations off and no subdomain, that scope is effectively global.
- `AdminOrganizationGate` exists, but the current routes use `role:admin` directly rather than the `org.admin` middleware.

## Instructor

### Features

- Instructor dashboard.
- Course/enrollment management view:
  - View enrolled-course records.
  - View enrollment progress data through the enrollment repository.
- Test/practice management:
  - List practice type details.
  - Create practice type details.
  - Show practice type detail records.
  - Update practice type details.
- Result practice management:
  - View result practice records.
- Student score leaderboard:
  - Rank students by total coins.
  - Filter leaderboard data by course, semester, practice, and score type.
  - Return filtered leaderboard data as JSON.
- Student activity/events:
  - View events for students enrolled in the instructor's courses.
  - Filter events by student, event type, and role.
- Instructor notes:
  - List notes created by the logged-in instructor.
  - Create notes for students in the instructor's classrooms.
  - Add a rating to a note.
  - Edit/update own notes.
  - Delete own notes.
- Class sessions:
  - List `normal` sessions taught by the logged-in instructor (free sessions are listed separately).
  - Create sessions for the instructor's own classrooms.
  - Store session start/end times, content, and session type.
  - Convert submitted local times to UTC.
  - Charge each student's parent for the session.
  - Queue calendar invite emails with ICS attachments to parent emails.
  - Edit own session content.
- Free trial session availability:
  - Publish open time slots for free trial sessions (multiple slots in one submit).
  - Submit slots in the browser's local timezone; they are converted to UTC, and invalid ranges (end ≤ start) are skipped.
  - Remove an availability slot, except slots that are already `booked`.
- Assigned free sessions:
  - Read-only list of free sessions an admin assigned to this instructor, with the attendee's details.
- Reports:
  - Per-student payout report with filters by month, student, classroom, and session type.
  - PDF export for per-student payout report.
  - Expected earnings report from assigned classroom schedules.
  - Payout per session is the full `teacher_payout` for each participating student (per-student model), not divided across students.
- Instructor profile:
  - Students can view an instructor profile with courses and course ratings.

### Organization Scope

- Instructor users can belong to an organization through `users.organization_id`.
- Organization admins assign instructors to organization classrooms.
- Session creation is limited to classrooms where `classrooms.instructor_id` is the logged-in instructor.
- Session types are loaded from the organization of the instructor's classroom.
- Parent transactions and calendar invites created by instructor sessions are tied to the students/parents enrolled in that classroom.
- Free-session availability and assigned free sessions are scoped to the logged-in instructor by `instructor_id` and are not tied to a classroom or organization.
- Note: `instructor/practice-details` routes are named/prefixed for instructor features, but currently have only `web` middleware in the route file, not `auth` or `role:instructor`.

## Student

### Features

- Student dashboard.
- Course browsing:
  - Browse course categories/taxonomies.
  - Browse courses.
  - View course paths and course counts.
  - View course lesson counts and total lesson time.
  - View course instructors.
  - View average course ratings.
- Course detail:
  - View course content and steps.
  - View lessons and practice steps in each content block.
  - View instructor details.
  - View rating summary, rating counts, and rating comments.
  - View more courses from the same instructor.
  - See whether the student is enrolled for the current semester.
- Course enrollment:
  - Enroll in a course for a selected semester.
  - Prevent duplicate enrollment for the same course and semester.
  - Log the enrollment event.
  - Create a parent debit transaction for the course price.
- Enrolled courses:
  - View enrolled courses grouped by taxonomy.
  - See lesson/practice progress and course ratings for enrolled courses.
- Lessons:
  - View a lesson inside a course.
  - Mark a lesson as watched.
  - Update lesson progress percentage on enrollment.
  - Log lesson-watch events.
- Course ratings:
  - Submit a 1 to 5 star course rating.
  - Add optional text review.
  - Log course-rating events.
- Learning paths:
  - List learning paths.
  - Show a path's courses.
  - See total lesson count/time and per-course instructor/rating data.
- Practice and exercises:
  - List practice types.
  - View practice levels.
  - Take quiz-style practices.
  - Submit result practice data as JSON.
  - View practice result page.
  - Run practice types:
    - `numbers_sum`
    - `abacus`
    - `math_games`
    - `math_games2`
  - Run practice as part of a course.
  - Run standalone exercises.
  - Search and open book exercises by exercise code.
  - Browse book exercises by class, book, and page.
  - Generate/view QR-based book exercise pages and book lists.
  - Check whether an exercise code exists.
  - Mark course practice as done.
  - Mark standalone exercise as done.
  - Mark book exercise as done.
  - Log wrong book-exercise answers.
  - Earn coins for solved practices and book exercises.
  - Update course practice progress when course practices are completed.
- Store/products:
  - Browse products and product categories.
  - Place pending product orders.
  - Orders are allowed only when total coins cover existing order totals plus the new product price.
  - Log product order events.
- Student-facing JSON APIs:
  - List categories.
  - List courses by category.
  - List course content.
  - Show specific course content.

### Organization Scope

- Student users can belong to an organization through `users.organization_id`.
- Login to an organization subdomain is allowed only when the student's `organization_id` matches that organization.
- Student catalog features such as courses, paths, practices, and products are mostly read from global repositories/controllers.
- Classroom session access is through classroom enrollment and parent/organization workflows rather than direct student classroom admin.

## Parentt

### Features

- Parent dashboard.
- Child progress:
  - View enrollments for linked children.
  - See child progress through course enrollment records.
- Child events:
  - View logged activity/events for linked children.
  - Filter by child, event type, and role.
- Instructor notes:
  - View instructor notes for linked children.
  - Mark notes as read.
  - Access is checked against the parent's own children.
- Classroom sessions:
  - View classroom sessions for classrooms containing linked children.
- Transactions and balance:
  - View parent transactions with student/course relations.
  - View parent balance.
  - Add money as a credit transaction.
- Absence requests:
  - List absence requests for linked children.
  - Create absence requests for upcoming sessions.
  - Choose only sessions where a linked child belongs to the classroom.
  - Auto-approve or auto-reject based on the organization's `absence_free_hours`.
  - Approved absence requests delete the matching debit transaction for that class session/student.

### Organization Scope

- Parent users can belong to an organization through `users.organization_id`.
- Login to an organization subdomain is allowed only when the parent's `organization_id` matches that organization.
- Parent access is driven by the `parentt_student` relationship, so parent screens show only linked children.
- Absence request rules use the parent user's organization setting `absence_free_hours`, with a fallback of 24 hours.
- Transactions are tied to the parent and, when applicable, the child, course, or class session.

## Guest / Public

### Features

- Public home page:
  - Shows categories.
  - Shows course paths and course counts.
  - Shows courses.
  - Shows course lesson counts and total lesson time.
  - Shows instructors.
  - Shows course ratings.
  - Shows blogs.
  - Computes total lesson count/time for each course path.
- Public blog detail page.
- Authentication:
  - Login page.
  - Login with email/password.
  - Logout.
  - Login/logout event logging.
  - Organization subdomain login validation for non-super-admin users.
- Locale switching by URL.
- Public/scaffold pages:
  - `tag/` index page.
  - `question/` index page.

### Organization Scope

- Public pages can receive the current organization from `OrganizationResolver`, but the guest controller reads global catalog/blog repositories.
- The auth controller enforces organization-subdomain matching after login for all roles except `super_admin`.

## External API Consumer (Passport)

These features serve an external application (for example a mobile/companion app) that authenticates with Laravel Passport access tokens instead of a web session. Routes live in `routes\api.php` and `Modules\Auth\Routes\api.php` under the `auth:api` guard.

### Features

- Token authentication (`/api/auth`):
  - `POST /api/auth/register` — self-register an account (first/last name, email, confirmed password); always creates a `student` account and returns a Bearer access token.
  - `POST /api/auth/login` — verify credentials and return a Bearer access token.
  - `GET /api/auth/me` — return the current authenticated user (token required).
  - `POST /api/auth/logout` — revoke the access token used for the current request.
- Generic authenticated probe:
  - `GET /api/user` — return the authenticated API user.
- Free trial session requests (`/api/free-sessions`, token required):
  - `GET /` — list the current user's own free-session requests (with the assigned instructor when scheduled).
  - `POST /` — submit a new request with an optional note; only one `pending` request is allowed at a time (returns `409` otherwise). The user only requests — an admin later assigns an instructor and time slot.
  - `DELETE /{freeSession}` — cancel the user's own request, only while it is still `pending`.

### Scope / Notes

- The free-session lifecycle is `pending` → `scheduled` (after admin assignment) or `cancelled`.
- Ownership is enforced by `user_id`; a request belonging to another user returns `404`.
- When an admin schedules the request, the requesting user receives an ICS calendar invite email for the free `ClassSession`.

## Shared Or Not Role-Specific

- `user-events` is registered with only `auth` middleware, despite the route name `admin.userevents` and the super admin sidebar placement.
- Several module controllers are scaffolds with empty `store`, `update`, or `destroy` methods and no meaningful role feature yet:
  - `Modules\User\Http\Controllers\UserController`
  - `Modules\Question\Http\Controllers\QuestionController`
  - `Modules\Tag\Http\Controllers\TagController`
  - `Modules\StudentActivity\Http\Controllers\StudentActivityController`
  - Scaffold methods inside some student/instructor/guest controllers.
- The legacy `auth:api` user placeholders have been superseded by the Passport auth and free-session API endpoints described in the External API Consumer section; `GET /api/user` remains as a generic authenticated probe.
- The student category/course/content API routes are exposed under the API middleware group without explicit role middleware in the module route files.
- `transactions.course_id` and `transactions.student_id` are now nullable, so wallet top-ups ("add money") and free sessions that are not tied to a course/student can be recorded.

## Free Trial Session System Summary

- A free trial session lets an external user request a one-off lesson without enrolling or being charged.
- Tables/entities:
  - `free_session_requests` (`FreeSessionRequest`): `user_id`, `note`, `status` (`pending`/`scheduled`/`cancelled`), plus `instructor_id`, `availability_id`, `class_session_id`, and `scheduled_at` once assigned.
  - `instructor_availabilities` (`InstructorAvailability`): `instructor_id`, `start_at`, `end_at`, `status` (`available`/`booked`).
  - `class_sessions` gained a `type` column (`normal`/`free`), an `end_at` column, and uses `student_user_id` as the free-session attendee. The model exposes `free()`/`normal()` scopes; reports use `normal()` so free sessions never affect payouts/profit.
- Flow: external user requests via the Passport API → request joins the admin waiting list → instructor publishes availability slots → admin assigns a pending request to an available slot → a free `ClassSession` is created, the slot is booked, and the user is emailed an ICS calendar invite.
- Times are stored in UTC; instructors submit availability in their local timezone and it is converted on save.

## Organization System Summary

- Organizations have `name`, `subdomain`, `theme_css`, `is_active`, and `absence_free_hours` fields.
- The entire organization system is gated behind `config('features.organizations')` (default off); see "Feature Flags & Master Switches" above.
- Seeded organizations are:
  - `yasmine`
  - `woderhafen`
- Organization admins are seeded for those organizations.
- Additional seeded organization members are currently scoped to the `yasmine` organization.
- `OrganizationResolver` reads the first subdomain segment when the host has more than two parts, shares `currentOrganization` with views, and attaches it to the request.
- Users have nullable `organization_id`.
- The database role name for parents is `parentt`.
