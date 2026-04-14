<?php

namespace Database\Seeders;

use App\Models\AnalyticsEvent;
use App\Models\ConnectionRequest;
use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── 1. Seed Admin ──────────────────────────────────────
        $adminPassword = env('ADMIN_PASSWORD', Str::random(12));

        User::firstOrCreate(
            ['email' => 'admin@devportfolio.com'],
            [
                'name'               => 'Platform Admin',
                'username'           => 'admin',
                'password'           => Hash::make($adminPassword),
                'role'               => 'admin',
                'is_active'          => true,
                'email_verified_at'  => now(),
            ]
        );

        $this->command->info('✓ Admin created: admin@devportfolio.com / password');

        // ── 2. Load JSON data files ────────────────────────────
        $developerData = json_decode(
            file_get_contents(database_path('data/developers.json')),
            true
        );

        $recruiterData = json_decode(
            file_get_contents(database_path('data/recruiters.json')),
            true
        );

        $userPassword = env('USER_PASSWORD', Str::random(12));

        // ── 3. Seed Developers ─────────────────────────────────
        $createdDevelopers = [];

        foreach ($developerData['developers'] as $dev) {

            // Create the user account
            $user = User::firstOrCreate(
                ['email' => $dev['email']],
                [
                    'name'              => $dev['name'],
                    'username'          => $dev['username'],
                    'password'          => Hash::make($userPassword),
                    'role'              => 'developer',
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );

            // Create portfolio
            $portfolio = Portfolio::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'headline'     => $dev['portfolio']['headline'],
                    'bio'          => $dev['portfolio']['bio'],
                    'location'     => $dev['portfolio']['location'],
                    'is_published' => true,
                    'social_links' => $dev['portfolio']['social_links'],
                ]
            );

            // Create skills
            foreach ($dev['skills'] as $skill) {
                Skill::firstOrCreate(
                    [
                        'portfolio_id' => $portfolio->id,
                        'name'         => $skill['name'],
                    ],
                    [
                        'category'    => $skill['category'],
                        'proficiency' => $skill['proficiency'],
                    ]
                );
            }

            // Create experiences
            foreach ($dev['experiences'] as $index => $exp) {
                Experience::firstOrCreate(
                    [
                        'portfolio_id' => $portfolio->id,
                        'company'      => $exp['company'],
                        'role'         => $exp['role'],
                    ],
                    [
                        'start_date'  => $exp['start_date'],
                        'end_date'    => $exp['end_date'],
                        'description' => $exp['description'],
                        'sort_order'  => $index,
                    ]
                );
            }

            // Create projects
            foreach ($dev['projects'] as $index => $proj) {
                Project::firstOrCreate(
                    [
                        'portfolio_id' => $portfolio->id,
                        'title'        => $proj['title'],
                    ],
                    [
                        'description'  => $proj['description'],
                        'tech_stack'   => $proj['tech_stack'],
                        'demo_url'     => $proj['demo_url'],
                        'repo_url'     => $proj['repo_url'],
                        'is_featured'  => $proj['is_featured'],
                        'sort_order'   => $index,
                    ]
                );
            }

            // Create testimonials
            foreach ($dev['testimonials'] as $testimonial) {
                Testimonial::firstOrCreate(
                    [
                        'portfolio_id'   => $portfolio->id,
                        'submitter_name' => $testimonial['submitter_name'],
                    ],
                    [
                        'submitter_role' => $testimonial['submitter_role'],
                        'company'        => $testimonial['company'],
                        'message'        => $testimonial['message'],
                        'rating'         => $testimonial['rating'],
                        'is_approved'    => $testimonial['is_approved'],
                    ]
                );
            }

            // Create fake analytics events
            // Simulate 30-90 page views spread over last 60 days
            $viewCount = rand(30, 90);
            for ($i = 0; $i < $viewCount; $i++) {
                AnalyticsEvent::create([
                    'portfolio_id' => $portfolio->id,
                    'event_type'   => 'page_view',
                    'referrer'     => collect([
                        'google.com',
                        'linkedin.com',
                        'twitter.com',
                        null,
                        null,
                    ])->random(),
                    'country_code' => collect(['EG', 'US', 'GB', 'DE', 'AE'])->random(),
                    'created_at'   => now()->subDays(rand(0, 60))
                                          ->subHours(rand(0, 23)),
                ]);
            }

            // Simulate project clicks
            $projects = $portfolio->projects;
            foreach ($projects as $project) {
                // 1. Identify which buttons actually exist for this project
                $availableEvents = [];
                if ($project->demo_url) $availableEvents[] = 'demo_click';
                if ($project->repo_url) $availableEvents[] = 'repo_click';

                // 2. Only create events if there is actually something to click
                if (!empty($availableEvents)) {
                    $clickCount = rand(3, 20);
                    for ($i = 0; $i < $clickCount; $i++) {
                        AnalyticsEvent::create([
                            'portfolio_id' => $portfolio->id,
                            'event_type'   => collect($availableEvents)->random(),
                            'referrer'     => null,
                            'country_code' => null,
                            'created_at'   => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                        ]);
                    }
                }
            }

            $createdDevelopers[] = $user;

            $this->command->info(
                "✓ Developer created: {$user->email} / password"
            );
        }

        // ── 4. Seed Recruiters ─────────────────────────────────
        $createdRecruiters = [];

        foreach ($recruiterData['recruiters'] as $rec) {

            // Generate username from name
            $username = strtolower(str_replace(
                [' ', '.', '-'],
                '_',
                explode('@', $rec['email'])[0]
            ));

            $user = User::firstOrCreate(
                ['email' => $rec['email']],
                [
                    'name'              => $rec['name'],
                    'username'          => $username,
                    'password'          => Hash::make($userPassword),
                    'role'              => 'recruiter',
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );

            $createdRecruiters[] = $user;

            $this->command->info(
                "✓ Recruiter created: {$user->email} / password"
            );
        }

        // ── 5. Seed Connection Requests ────────────────────────
        // Each recruiter sends requests to some developers
        foreach ($createdRecruiters as $recruiter) {

            // Pick 2-3 random developers to send requests to
            $targets = collect($createdDevelopers)
                ->shuffle()
                ->take(rand(2, 3));

            $statuses = ['pending', 'accepted', 'declined'];

            foreach ($targets as $developer) {

                // Avoid duplicates
                $exists = ConnectionRequest::where('recruiter_id', $recruiter->id)
                    ->where('developer_id', $developer->id)
                    ->exists();

                if ($exists) continue;

                $status = collect($statuses)->random();

                ConnectionRequest::create([
                    'recruiter_id' => $recruiter->id,
                    'developer_id' => $developer->id,
                    'message'      => collect([
                        "Hi! I came across your portfolio and I'm very impressed with your work. We have an exciting opportunity that I think would be a great fit for your skills.",
                        "Your projects look amazing! We are currently hiring and I believe you would be a fantastic addition to our team.",
                        "I noticed your experience with {$developer->portfolio->headline}. We have a position that aligns perfectly with your background.",
                        "Hello! I would love to discuss a senior developer position we have open. Your skills seem like a perfect match.",
                        null,
                    ])->random(),
                    'status'       => $status,
                    'responded_at' => in_array($status, ['accepted', 'declined'])
                        ? now()->subDays(rand(1, 10))
                        : null,
                ]);
            }
        }

        $this->command->info('✓ Connection requests created');

        // ── Summary ────────────────────────────────────────────
        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('  DevPortfolio Seeding Complete!');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('  Admin:      admin@devportfolio.com');
        $this->command->info('  Password:   password');
        $this->command->info('  Developers: ' . count($createdDevelopers));
        $this->command->info('  Recruiters: ' . count($createdRecruiters));
        $this->command->info('───────────────────────────────────────');
        $this->command->info('  Developer logins:');
        foreach ($createdDevelopers as $dev) {
            $this->command->info("  → {$dev->email}");
        }
        $this->command->info('───────────────────────────────────────');
        $this->command->info('  Recruiter logins:');
        foreach ($createdRecruiters as $rec) {
            $this->command->info("  → {$rec->email}");
        }
        $this->command->info('═══════════════════════════════════════');
    }
}