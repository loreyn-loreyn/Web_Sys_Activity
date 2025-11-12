<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ResumeController extends Controller
{
    protected $middleware = [
        ['auth', ['except' => ['preview']]]
    ];

    /**
     * Get the current user's resume, or create a default one if missing.
     */
    private function getOrCreateResume()
    {
        $user = Auth::user();

        return Resume::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name ?? "SOPHIA LOUREINE M. BULANADI",
                'title' => "Software Engineer",
                'profile' => "Detail-oriented and innovative Software Engineer with 4+ years of experience in developing scalable web applications and enterprise solutions.",
                'contact' => [
                    "🏠︎ 333, Purok 6, Brgy. Sampaloc, Talavera, Nueva Ecija",
                    "☎ 09661565006",
                    "✉︎ bulanadi.sophia@gmail.com",
                    "🔗 linkedin.com/in/sophialoureine",
                    "💻 github.com/loreyn-loreyn"
                ],
                'education' => "Batangas State University  
Bachelor of Science in Computer Science, 2027 (Cum Laude)",
                'skills' => [
                    "Languages: C, Java, HTML, C#, PHP, Dart",
                    "Web: Laravel, Flutter",
                    "Databases: MySQL, PostgreSQL",
                    "Cloud & Tools: Git",
                    "Soft Skills: Agile/Scrum, Problem-Solving, Collaboration"
                ],
                'experience' => [
                    [
                        "company" => "Globe Telecom, Makati City",
                        "date" => "June 2029 - Present",
                        "tasks" => [
                            "Developed and maintained scalable web apps with Laravel & React.js, serving 1M+ customers",
                            "Integrated secure payment gateway APIs, reducing transaction errors by 30%",
                            "Led a team of 5 junior developers in coding best practices and Git workflows",
                            "Deployed applications on AWS with 99.9% uptime"
                        ]
                    ],
                    [
                        "company" => "Accenture Philippines, Taguig City",
                        "date" => "July 2027 - May 2029",
                        "tasks" => [
                            "Built responsive dashboards with Vue.js and Laravel, enhancing reporting efficiency",
                            "Automated unit testing with QA team, reducing bugs by 25%",
                            "Wrote reusable components and documentation adopted company-wide"
                        ]
                    ]
                ]
            ]
        );
    }

public function preview($user_id)
{
    $resume = Resume::where('user_id', $user_id)->first();

    if (!$resume) {
        abort(404, 'Resume not found');
    }

    // Ensure fields are arrays
$contact = $resume->contact ?? [];
$skills = $resume->skills ?? [];
$experience = $resume->experience ?? [];

    return view('resume_preview', [
        'name' => $resume->name,
        'title' => $resume->title,
        'profile' => $resume->profile,
        'contact' => $resume->contact,
        'education' => $resume->education,
        'skills' => $resume->skills,
        'experience' => $resume->experience,
    ]);
}


    public function show()
    {
        $resume = $this->getOrCreateResume();

$contact = $resume->contact ?? [];
$skills = $resume->skills ?? [];
$experience = $resume->experience ?? [];

        return view('resume', [
            'name' => $resume->name,
            'title' => $resume->title,
            'profile' => $resume->profile,
            'contact' => $contact,
            'education' => $resume->education,
            'skills' => $skills,
            'experience' => $experience,
            'resume_user_id' => $resume->user_id,
        ]);
    }

        public function edit()
    {
        $resume = $this->getOrCreateResume();

        return view('resume_edit', [
            'resume' => $resume
        ]);
    }

public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'title' => 'required|string',
        'profile' => 'required|string',
    ]);

    $resume = Resume::where('user_id', Auth::id())->firstOrFail();

    // Contact & skills from textarea (line separated)
    $contact = array_filter(array_map('trim', explode("\n", $request->contact ?? '')));
    $skills = array_filter(array_map('trim', explode("\n", $request->skills ?? '')));

    // Experience: array of arrays from the form
    $experienceInput = $request->input('experience', []);
    $experience = [];

$experience = [];
if ($request->has('experience')) {
    foreach ($request->experience as $exp) {
        // Split tasks by new line
        $tasks = array_filter(array_map('trim', explode("\n", $exp['tasks'] ?? '')));
        $experience[] = [
            'company' => $exp['company'] ?? '',
            'date' => $exp['date'] ?? '',
            'tasks' => $tasks,
        ];
    }
}

$resume->update([
    'name' => $request->name,
    'title' => $request->title,
    'profile' => $request->profile,
    'contact' => array_filter(array_map('trim', explode("\n", $request->contact ?? ''))),
    'education' => $request->education ?? '',
    'skills' => array_filter(array_map('trim', explode("\n", $request->skills ?? ''))),
    'experience' => $experience,
]);

    return redirect()->route('resume.show')->with('success', 'Resume updated successfully.');
}


}
