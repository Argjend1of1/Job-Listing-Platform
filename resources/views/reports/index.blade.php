<x-layout>
    <x-page-heading>Reports</x-page-heading>
    <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
        @if($reports->first() !== null)
            @foreach($reports as $report)
                <div>
                    <x-report-card :$report :job="$report->job"/>
                </div>
            @endforeach
        @else
            <p class="text-gray-500 font-semibold">No reports made yet.</p>
        @endif
    </div>
</x-layout>
