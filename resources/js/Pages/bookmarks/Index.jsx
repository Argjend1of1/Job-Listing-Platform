import {usePage} from "@inertiajs/react";
import JobCard from "@/Pages/components/cards/JobCard.jsx";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";

const Index = () => {
    const {jobs} = usePage().props
    // console.log();

    return (

        <>
            <PageHeading title='Bookmarks' />

            <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
                {jobs && jobs.map(job => (
                    <div key={job.id}>
                        <JobCard job={job} route={`/jobs/${job.id}/bookmark`}/>
                    </div>
                ))}
            </div>

            {jobs.length === 0 && (
                <p className="text-gray-500 font-bold mt-5">
                    You currently have no bookmarked jobs. <a href='/jobs' className="text-blue-500 underline">
                        Search for a job
                    </a>
                </p>
            )}
        </>
    )
}

export default Index;
