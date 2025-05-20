<div class="bg-white/10 rounded-xl mt-4 p-5 hover:shadow-lg hover:border border-blue-800 cursor-pointer transition duration-300">
    <div class="space-y-5 ">
        <!-- Reported Job Section -->
        <div>
            <p class="text-sm text-gray-300 font-medium">📄 Reported Job:</p>
            <a href="/jobs/{{$report->job_id}}" class="text-xl font-semibold text-white hover:underline cursor-pointer">
                {{ $report->job->title }}
            </a>
        </div>

        <!-- Published By Section -->
        <div>
            <p class="text-sm text-gray-300 font-medium">🏢 Published By:</p>
            <a href="" class="text-white font-semibold">
                {{ $report->job->employer->user->name }}
                <span class="text-sm text-gray-400">({{ $report->job->employer->user->email }})</span>
            </a>
        </div>

        <hr class="border-gray-700">

        <!-- Reported By Section -->
        <div>
            <p class="text-sm text-gray-300 font-medium">🧑‍💼 Reported By:</p>
            <p class="text-white font-semibold">
                {{ $report->user->name }}
                <span class="text-sm text-gray-400">({{ $report->user->email }})</span>
            </p>
        </div>
    </div>
</div>
