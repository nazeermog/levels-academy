@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $locale    = app()->getLocale();
    $isRtl     = in_array($locale, ['ar', 'he', 'fa']);
    $altLocale = $locale === 'ar' ? 'en' : 'ar';
    Carbon::setLocale($locale);

    $coursesList = collect($courses ?? []);
    $pathsList   = collect($coursePaths ?? []);
    $blogList    = collect($blogs ?? []);

    // Stats
    $coursesCount     = $coursesList->count();
    $pathsCount       = $pathsList->count();
    $lessonsCount     = is_array($courseLessons ?? null) ? array_sum($courseLessons) : 0;
    $instructorsCount = collect($instructor ?? [])->filter()->map(fn ($i) => $i->id ?? null)->filter()->unique()->count();

    // Count helpers (locale aware)
    $courseWord = fn ($n) => $n . ' ' . ($n == 1 ? __('landing.word_course') : __('landing.word_courses'));
    $lessonWord = fn ($n) => $n . ' ' . ($n == 1 ? __('landing.word_lesson') : __('landing.word_lessons'));

    // Org-aware branding: on yasmine.levels-academy.com show the org's logo, name and theme.
    $org          = $currentOrganization ?? null;
    $defaultBrand = __('landing.hero_eyebrow');
    $brandName    = $org && $org->name ? $org->name : $defaultBrand;
    $brandLogo    = $org ? asset('images/logo/' . $org->subdomain . '.png') : asset('images/logo/Levels-logo.png');
    // Swap the brand name inside translated prose without forking the lang files.
    $brand        = fn ($key, $r = []) => str_replace($defaultBrand, $brandName, __($key, $r));
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $brandName }} — {{ __('landing.cta_title') }}</title>
    <meta name="description" content="{{ strip_tags(__('landing.hero_lead')) }}">
    <link rel="icon" href="{{ $brandLogo }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/landing.css') }}" rel="stylesheet">
    @if ($org)
    {{-- Yasmine brand recolor: green-dominant (emerald + mint) with a jasmine-pink accent. --}}
    <style>
        :root {
            --teal: #2f9e7a; --teal-dark: #1f7a50; --teal-darker: #16593a; --teal-soft: #eaf7f1;
            --gradient: linear-gradient(135deg, #57c99a 0%, #1f7a50 100%);
            --gradient-dark: linear-gradient(135deg, #1f7a50 0%, #12583a 100%);
        }
        .hero__blob--2 { background: linear-gradient(135deg, #d996b0, var(--teal)) !important; }
    </style>
    @endif
</head>

<body class="{{ $isRtl ? 'is-rtl' : '' }}">

    {{-- ============================ NAVBAR ============================ --}}
    <header class="nav" id="nav">
        <div class="container nav__inner">
            <a href="{{ route('guest.index') }}" class="nav__brand">
                <img src="{{ $brandLogo }}" alt="{{ $brandName }}">
            </a>

            <ul class="nav__links">
                <li><a href="#features">{{ __('landing.nav_features') }}</a></li>
                @if ($pathsList->count())
                    <li><a href="#paths">{{ __('landing.nav_paths') }}</a></li>
                @endif
                <li><a href="#courses">{{ __('landing.nav_courses') }}</a></li>
                @if ($blogList->count())
                    <li><a href="#blog">{{ __('landing.nav_blog') }}</a></li>
                @endif
                <li><a href="#how">{{ __('landing.nav_how') }}</a></li>
            </ul>

            <div class="nav__actions">
                <a href="{{ route('locale.setting', ['locale' => $altLocale]) }}" class="lang">{{ __('landing.lang_switch') }}</a>
                <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('landing.nav_login') }}</a>
                <a href="{{ route('login') }}" class="btn btn-primary">{{ __('landing.nav_get_started') }}</a>
                <button class="nav__toggle" id="navToggle" aria-label="Menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
            </div>
        </div>
    </header>

    <div class="mobile-menu" id="mobileMenu">
        <a href="#features">{{ __('landing.nav_features') }}</a>
        @if ($pathsList->count())
            <a href="#paths">{{ __('landing.nav_paths') }}</a>
        @endif
        <a href="#courses">{{ __('landing.nav_courses') }}</a>
        @if ($blogList->count())
            <a href="#blog">{{ __('landing.nav_blog') }}</a>
        @endif
        <a href="#how">{{ __('landing.nav_how') }}</a>
        <a href="{{ route('locale.setting', ['locale' => $altLocale]) }}">{{ __('landing.lang_switch') }}</a>
        <a href="{{ route('login') }}" class="btn btn-ghost btn-block">{{ __('landing.nav_login') }}</a>
        <a href="{{ route('login') }}" class="btn btn-primary btn-block">{{ __('landing.nav_get_started') }}</a>
    </div>

    {{-- ============================ HERO ============================ --}}
    <section class="hero">
        <div class="container hero__grid">
            <div class="hero__copy">
                <span class="eyebrow"><span class="dot"></span> {{ $brandName }}</span>
                <h1>{!! __('landing.hero_title') !!}</h1>
                <p class="hero__lead">{{ __('landing.hero_lead') }}</p>
                <div class="hero__cta">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        {{ __('landing.hero_start') }}
                        <svg class="dir-flip" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="#courses" class="btn btn-ghost btn-lg">{{ __('landing.hero_browse') }}</a>
                </div>
                <div class="hero__stats">
                    <div class="hero__stat">
                        <div class="n">{{ $coursesCount }}+</div>
                        <div class="l">{{ __('landing.label_courses') }}</div>
                    </div>
                    @if ($pathsCount)
                        <div class="hero__stat">
                            <div class="n">{{ $pathsCount }}+</div>
                            <div class="l">{{ __('landing.label_paths') }}</div>
                        </div>
                    @else
                        <div class="hero__stat">
                            <div class="n">{{ $instructorsCount }}+</div>
                            <div class="l">{{ __('landing.label_instructors_short') }}</div>
                        </div>
                    @endif
                    <div class="hero__stat">
                        <div class="n">{{ $lessonsCount }}+</div>
                        <div class="l">{{ __('landing.label_lessons') }}</div>
                    </div>
                </div>
            </div>

            <div class="hero__visual reveal">
                <span class="hero__blob hero__blob--1"></span>
                <span class="hero__blob hero__blob--2"></span>
                <div class="hero__photo">
                    <img src="{{ asset('images/photodune-4161018-group-of-students-m.jpg') }}" alt="{{ $brandName }}">
                </div>
                <div class="float-card float-card--tl">
                    <span class="ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </span>
                    <div>
                        <div class="t">{{ $courseWord($coursesCount) }}</div>
                        <div class="s">{{ __('landing.float_growing') }}</div>
                    </div>
                </div>
                <div class="float-card float-card--br">
                    <span class="ico">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.6-5.2 4.5 1.6 6.7L12 17l-6.2 3.6 1.6-6.7L2.2 8.9l6.9-.6z"/></svg>
                    </span>
                    <div>
                        <div class="t">4.9 / 5</div>
                        <div class="s stars-mini">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.6-5.2 4.5 1.6 6.7L12 17l-6.2 3.6 1.6-6.7L2.2 8.9l6.9-.6z"/></svg>
                            <span style="color:var(--muted)">{{ __('landing.float_rating') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ STATS BAND ============================ --}}
    <section class="statband">
        <div class="container statband__grid {{ $pathsCount ? '' : 'statband__grid--3' }}">
            <div class="statband__item">
                <div class="statband__ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div>
                <div class="n">{{ $coursesCount }}</div><div class="l">{{ __('landing.label_courses') }}</div>
            </div>
            @if ($pathsCount)
                <div class="statband__item">
                    <div class="statband__ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l6-6 4 4 8-8"/><path d="M21 7v5h-5"/></svg></div>
                    <div class="n">{{ $pathsCount }}</div><div class="l">{{ __('landing.label_paths') }}</div>
                </div>
            @endif
            <div class="statband__item">
                <div class="statband__ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div class="n">{{ $instructorsCount }}</div><div class="l">{{ __('landing.label_instructors') }}</div>
            </div>
            <div class="statband__item">
                <div class="statband__ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg></div>
                <div class="n">{{ $lessonsCount }}</div><div class="l">{{ __('landing.label_lessons') }}</div>
            </div>
        </div>
    </section>

    {{-- ============================ FEATURES ============================ --}}
    <section class="section" id="features">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow"><span class="dot"></span> {{ __('landing.features_eyebrow') }}</span>
                <h2>{{ __('landing.features_title') }}</h2>
                <p>{{ $brand('landing.features_sub') }}</p>
            </div>

            <div class="grid-3">
                <div class="feature feature--teal reveal">
                    <div class="feature__ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <h3>{{ __('landing.f1_t') }}</h3>
                    <p>{{ __('landing.f1_d') }}</p>
                </div>
                <div class="feature feature--purple reveal" data-delay="1">
                    <div class="feature__ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l6-6 4 4 8-8"/><path d="M21 7v5h-5"/></svg>
                    </div>
                    <h3>{{ __('landing.f2_t') }}</h3>
                    <p>{{ __('landing.f2_d') }}</p>
                </div>
                <div class="feature feature--coral reveal" data-delay="2">
                    <div class="feature__ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                    </div>
                    <h3>{{ __('landing.f3_t') }}</h3>
                    <p>{{ __('landing.f3_d') }}</p>
                </div>
                <div class="feature feature--green reveal">
                    <div class="feature__ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <h3>{{ __('landing.f4_t') }}</h3>
                    <p>{{ __('landing.f4_d') }}</p>
                </div>
                <div class="feature feature--amber reveal" data-delay="1">
                    <div class="feature__ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="11" width="3" height="6"/><rect x="12" y="7" width="3" height="10"/><rect x="17" y="13" width="3" height="4"/></svg>
                    </div>
                    <h3>{{ __('landing.f5_t') }}</h3>
                    <p>{{ __('landing.f5_d') }}</p>
                </div>
                <div class="feature feature--blue reveal" data-delay="2">
                    <div class="feature__ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3>{{ __('landing.f6_t') }}</h3>
                    <p>{{ __('landing.f6_d') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ LEARNING PATHS ============================ --}}
    @if ($pathsList->count())
        <section class="section section--soft" id="paths">
            <div class="container">
                <div class="section-head reveal">
                    <span class="eyebrow"><span class="dot"></span> {{ __('landing.paths_eyebrow') }}</span>
                    <h2>{{ __('landing.paths_title') }}</h2>
                    <p>{{ __('landing.paths_sub') }}</p>
                </div>

                <div class="cards cards--3">
                    @foreach ($pathsList->take(6) as $path)
                        <a href="{{ route('student.path.show', ['pathId' => $path->id]) }}" class="pathcard reveal">
                            <img class="pathcard__img" src="{{ asset($path->photo) }}" alt="{{ $path->title }}"
                                 onerror="this.style.visibility='hidden'">
                            <div>
                                <div class="pathcard__title">{{ $path->title }}</div>
                                <div class="pathcard__meta">
                                    {{ $courseWord($coursesCounts[$path->id] ?? 0) }}
                                    @if (!empty($path->totalLessonCount)) · {{ $lessonWord($path->totalLessonCount) }} @endif
                                </div>
                            </div>
                            <span class="pathcard__arrow">
                                <svg class="dir-flip" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ COURSES ============================ --}}
    @if ($coursesList->count())
        <section class="section" id="courses">
            <div class="container">
                <div class="section-head reveal">
                    <span class="eyebrow"><span class="dot"></span> {{ __('landing.courses_eyebrow') }}</span>
                    <h2>{{ __('landing.courses_title') }}</h2>
                    <p>{{ __('landing.courses_sub') }}</p>
                </div>

                <div class="cards">
                    @foreach ($coursesList->take(8) as $course)
                        @php
                            $rate = (int) round($courseRate[$course->id] ?? 0);
                            $teacher = $instructor[$course->id] ?? null;
                            $lessons = $courseLessons[$course->id] ?? 0;
                        @endphp
                        <a href="{{ route('student.courses.show', ['CourseId' => $course->id]) }}" class="card reveal">
                            <div class="card__media">
                                <img src="{{ asset($course->photo) }}" alt="{{ $course->title }}"
                                     onerror="this.src='{{ asset('images/1280_work-station-straight-on-view.jpg') }}'">
                                @if (!empty($course->level))
                                    <span class="card__badge">{{ ucfirst($course->level) }}</span>
                                @endif
                            </div>
                            <div class="card__body">
                                <div class="card__title">{{ $course->title }}</div>
                                @if ($teacher)
                                    <div class="card__sub">{{ trim(($teacher->first_name ?? '') . ' ' . ($teacher->last_name ?? '')) }}</div>
                                @endif
                                <div class="stars" aria-label="{{ $rate }} / 5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="{{ $i <= $rate ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.3 6.9.6-5.2 4.5 1.6 6.7L12 17l-6.2 3.6 1.6-6.7L2.2 8.9l6.9-.6z"/></svg>
                                    @endfor
                                </div>
                                <div class="card__meta">
                                    <span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2" stroke-linecap="round"/></svg>
                                        @if (!empty($totalLessonTime[$course->id]))
                                            {{ Carbon::now()->addMinutes($totalLessonTime[$course->id])->diffForHumans(null, true, false, 2) }}
                                        @else
                                            {{ __('landing.courses_selfpaced') }}
                                        @endif
                                    </span>
                                    <span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                        {{ $lessonWord($lessons) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="section__cta">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">{{ __('landing.courses_viewall') }}</a>
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ HOW IT WORKS ============================ --}}
    <section class="section section--soft" id="how">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow"><span class="dot"></span> {{ __('landing.how_eyebrow') }}</span>
                <h2>{{ __('landing.how_title') }}</h2>
            </div>
            <div class="steps">
                <div class="step reveal">
                    <div class="step__num">1</div>
                    <h3>{{ __('landing.step1_t') }}</h3>
                    <p>{{ $brand('landing.step1_d') }}</p>
                </div>
                <div class="step reveal" data-delay="1">
                    <div class="step__num">2</div>
                    <h3>{{ __('landing.step2_t') }}</h3>
                    <p>{{ __('landing.step2_d') }}</p>
                </div>
                <div class="step reveal" data-delay="2">
                    <div class="step__num">3</div>
                    <h3>{{ __('landing.step3_t') }}</h3>
                    <p>{{ __('landing.step3_d') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ BLOG ============================ --}}
    @if ($blogList->count())
        <section class="section" id="blog">
            <div class="container">
                <div class="section-head reveal">
                    <span class="eyebrow"><span class="dot"></span> {{ __('landing.blog_eyebrow') }}</span>
                    <h2>{{ __('landing.blog_title') }}</h2>
                    <p>{{ $brand('landing.blog_sub') }}</p>
                </div>

                <div class="cards cards--3">
                    @foreach ($blogList->take(3) as $blog)
                        @php
                            $author = trim((optional($blog->user)->first_name ?? '') . ' ' . (optional($blog->user)->last_name ?? ''));
                            $initials = Str::upper(Str::substr($author ?: 'L', 0, 1));
                        @endphp
                        <a href="{{ route('blog.show', ['blogid' => $blog->id]) }}" class="card blogcard reveal">
                            <div class="card__media blogcard__media">
                                <img src="{{ asset($blog->photo) }}" alt="{{ $blog->title }}"
                                     onerror="this.src='{{ asset('images/1280_writing-down-goals_4460x4460.jpg') }}'">
                            </div>
                            <div class="card__body">
                                @if ($blog->created_at)
                                    <div class="blogcard__date">{{ $blog->created_at->locale($locale)->isoFormat('LL') }}</div>
                                @endif
                                <div class="card__title">{{ $blog->title }}</div>
                                <div class="blogcard__foot">
                                    <span class="blogcard__avatar">{{ $initials }}</span>
                                    <span class="blogcard__author">{{ $author ?: $brand('landing.blog_author_fallback') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ CTA ============================ --}}
    <section class="section">
        <div class="container">
            <div class="cta reveal">
                <span class="cta__pattern"></span>
                <div class="cta__inner">
                    <h2>{{ __('landing.cta_title') }}</h2>
                    <p>{{ $brand('landing.cta_sub') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-white btn-lg">{{ __('landing.cta_btn') }}</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ FOOTER ============================ --}}
    <footer class="footer">
        <div class="container">
            <div class="footer__grid">
                <div class="footer__brand">
                    <img src="{{ $brandLogo }}" alt="{{ $brandName }}">
                    <p>{{ __('landing.footer_about') }}</p>
                </div>
                <div>
                    <h4>{{ __('landing.footer_platform') }}</h4>
                    <ul>
                        <li><a href="#features">{{ __('landing.nav_features') }}</a></li>
                        @if ($pathsList->count())
                            <li><a href="#paths">{{ __('landing.nav_paths') }}</a></li>
                        @endif
                        <li><a href="#courses">{{ __('landing.nav_courses') }}</a></li>
                        <li><a href="#how">{{ __('landing.nav_how') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4>{{ __('landing.footer_account') }}</h4>
                    <ul>
                        <li><a href="{{ route('login') }}">{{ __('landing.nav_login') }}</a></li>
                        <li><a href="{{ route('login') }}">{{ __('landing.nav_get_started') }}</a></li>
                        @if ($blogList->count())
                            <li><a href="#blog">{{ __('landing.nav_blog') }}</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4>{{ __('landing.footer_getapp') }}</h4>
                    <ul>
                        <li><a href="{{ route('login') }}">{{ __('landing.footer_students') }}</a></li>
                        <li><a href="{{ route('login') }}">{{ __('landing.footer_instructors') }}</a></li>
                        <li><a href="{{ route('login') }}">{{ __('landing.footer_parents') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <span>{{ $brand('landing.footer_rights', ['year' => date('Y')]) }}</span>
                <div class="footer__social">
                    <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                    <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        var nav = document.getElementById('nav');
        window.addEventListener('scroll', function () {
            nav.classList.toggle('scrolled', window.scrollY > 8);
        });

        var toggle = document.getElementById('navToggle');
        var menu = document.getElementById('mobileMenu');
        if (toggle) {
            toggle.addEventListener('click', function () { menu.classList.toggle('open'); });
            menu.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () { menu.classList.remove('open'); });
            });
        }

        var reveals = document.querySelectorAll('.reveal');
        var revealAll = function () { reveals.forEach(function (el) { el.classList.add('in'); }); };
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
                });
            }, { threshold: 0.12 });
            reveals.forEach(function (el) { io.observe(el); });
            // Safety net: never leave content hidden if the observer doesn't fire
            setTimeout(revealAll, 1500);
        } else {
            revealAll();
        }
    </script>

</body>

</html>
