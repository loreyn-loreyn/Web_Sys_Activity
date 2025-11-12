<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resume</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-6">

    @include('component.logout')

    <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-2xl p-8">
        <h1 class="text-3xl font-bold text-green-700 mb-6">Edit Resume</h1>

        <form method="POST" action="{{ route('resume.update') }}">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $resume->name) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring focus:ring-green-300" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Title / Position</label>
                <input type="text" name="title" value="{{ old('title', $resume->title) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring focus:ring-green-300" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Profile Summary</label>
                <textarea name="profile" rows="4"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring focus:ring-green-300" required>{{ old('profile', $resume->profile) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Education</label>
                <textarea name="education" rows="3"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring focus:ring-green-300">{{ old('education', $resume->education) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Contact (one per line)</label>
                <textarea name="contact" rows="4"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring focus:ring-green-300">{{ implode("\n", is_array($resume->contact) ? $resume->contact : json_decode($resume->contact, true) ?? []) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Skills (one per line)</label>
                <textarea name="skills" rows="4"
                    class="w-full border border-gray-300 rounded-lg p-2 mt-1 focus:ring focus:ring-green-300">{{ implode("\n", is_array($resume->skills) ? $resume->skills : json_decode($resume->skills, true) ?? []) }}</textarea>
            </div>

            <div class="mb-6">
                
            <label class="font-semibold">Experience</label>

            <div id="experience-container">
                @foreach($resume->experience as $i => $exp)
                    <div class="mb-4 border p-3 rounded" data-index="{{ $i }}">
                        <input type="text" name="experience[{{ $i }}][company]" value="{{ $exp['company'] }}" placeholder="Company" class="w-full mb-1 p-2 border rounded">
                        <input type="text" name="experience[{{ $i }}][date]" value="{{ $exp['date'] }}" placeholder="Date" class="w-full mb-1 p-2 border rounded">
                        <textarea name="experience[{{ $i }}][tasks]" placeholder="Tasks (one per line)" class="w-full p-2 border rounded">{{ implode("\n", $exp['tasks']) }}</textarea>
                        <button type="button" onclick="removeExperience(this)" class="text-red-600 mt-1">Remove</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addExperience()" class="mt-2 bg-green-600 text-white px-4 py-2 rounded">Add Experience</button>

            </div>
            <div class="flex justify-between">
                <a href="{{ route('resume.show') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow transition">
                   Cancel
                </a>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <script>
        let expIndex = {{ count($resume->experience) }};
        function addExperience() {
            let container = document.getElementById('experience-container');
            let div = document.createElement('div');
            div.classList.add('mb-4', 'border', 'p-3', 'rounded');
            div.innerHTML = `
                <input type="text" name="experience[${expIndex}][company]" placeholder="Company" class="w-full mb-1 p-2 border rounded">
                <input type="text" name="experience[${expIndex}][date]" placeholder="Date" class="w-full mb-1 p-2 border rounded">
                <textarea name="experience[${expIndex}][tasks]" placeholder="Tasks (one per line)" class="w-full p-2 border rounded"></textarea>
                <button type="button" onclick="removeExperience(this)" class="text-red-600 mt-1">Remove</button>
            `;
            container.appendChild(div);
            expIndex++;
        }

        function removeExperience(btn) {
            btn.parentElement.remove();
        }
    </script>

</body>
</html>
