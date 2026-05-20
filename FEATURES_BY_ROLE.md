# Project Features By Role

This inventory was built from the route files and controllers in `DataSource\Http\Controllers`, `Modules\*\Http\Controllers`, `app\Http\Middleware`, and the role/organization seeders.

## Roles Found In The Code

- `super_admin`
- `admin`
- `instructor`
- `student`
- `parentt`
- Guest/public users have no stored role, but have public pages and auth routes.

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
- User event audit:
  - View user events.
  - Filter events by user, event type, and role.
- Authentication:
  - Can log in from any organization subdomain.
  - Logs login/logout events.

### Organization Scope

- `super_admin` is global and is not limited by `organization_id`.
- `User::hasRoles()` lets `super_admin` pass every role check.
- Organization login checks do not block `super_admin`.
- This role can create, edit, and delete organizations and can manage global catalog/content data used by organizations.

## Organization Admin

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
- Classroom reports:
  - Instructor totals by month, instructor, classroom, and session type.
  - Profit report comparing session revenue and instructor payouts.
  - Student dues report showing charges, credits, net dues, and transaction counts.
  - Expected earnings report projecting revenue, payout, and profit from classroom schedules.
- Instructor notes:
  - View notes for the organization when the current organization subdomain is `yasmine`.

### Organization Scope

- The current organization is resolved from the request subdomain by `OrganizationResolver`.
- Login blocks non-super-admin users when their `organization_id` does not match the current subdomain organization.
- Organization admin routes use `role:admin`.
- Classroom, session type, dashboard, users, settings, and report controllers scope data to `currentOrganization` where applicable.
- The sidebar only shows the classroom/session/report/settings block for the `yasmine` subdomain, but most corresponding routes/controllers are registered for any `admin` and scope by current organization.
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
  - List sessions taught by the logged-in instructor.
  - Create sessions for the instructor's own classrooms.
  - Store session start/end times, content, and session type.
  - Convert submitted local times to UTC.
  - Charge each student's parent for the session.
  - Queue calendar invite emails with ICS attachments to parent emails.
  - Edit own session content.
- Reports:
  - Per-student payout report with filters by month, student, classroom, and session type.
  - PDF export for per-student payout report.
  - Expected earnings report from assigned classroom schedules.
- Instructor profile:
  - Students can view an instructor profile with courses and course ratings.

### Organization Scope

- Instructor users can belong to an organization through `users.organization_id`.
- Organization admins assign instructors to organization classrooms.
- Session creation is limited to classrooms where `classrooms.instructor_id` is the logged-in instructor.
- Session types are loaded from the organization of the instructor's classroom.
- Parent transactions and calendar invites created by instructor sessions are tied to the students/parents enrolled in that classroom.
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

## Shared Or Not Role-Specific

- `user-events` is registered with only `auth` middleware, despite the route name `admin.userevents` and the super admin sidebar placement.
- Several module controllers are scaffolds with empty `store`, `update`, or `destroy` methods and no meaningful role feature yet:
  - `Modules\User\Http\Controllers\UserController`
  - `Modules\Question\Http\Controllers\QuestionController`
  - `Modules\Tag\Http\Controllers\TagController`
  - `Modules\StudentActivity\Http\Controllers\StudentActivityController`
  - Scaffold methods inside some student/instructor/guest controllers.
- API route files mostly expose "return authenticated API user" placeholders under `auth:api`.
- The student category/course/content API routes are exposed under the API middleware group without explicit role middleware in the module route files.

## Organization System Summary

- Organizations have `name`, `subdomain`, `theme_css`, and `is_active` fields.
- Seeded organizations are:
  - `yasmine`
  - `woderhafen`
- Organization admins are seeded for those organizations.
- Additional seeded organization members are currently scoped to the `yasmine` organization.
- `OrganizationResolver` reads the first subdomain segment when the host has more than two parts, shares `currentOrganization` with views, and attaches it to the request.
- Users have nullable `organization_id`.
- The database role name for parents is `parentt`.
