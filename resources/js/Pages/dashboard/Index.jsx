import {Link, usePage} from "@inertiajs/react";
import JobCardWide from "@/Pages/components/cards/JobCardWide.jsx";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";

const Index = () => {
    const {jobs, user, logo} = usePage().props;
    console.log(jobs)

    return (
        <>
            <PageHeading title="Your Listed Jobs"/>
            {jobs.length > 0 ? (
                jobs.map(job => (
                    <div key={job.id}>
                        <JobCardWide user={user} logo={logo} job={job}/>
                    </div>
                ))
            ) : (
                <p className="text-gray-400 mt-4 font-semibold">
                    You haven’t listed any jobs yet. <Link
                        className="hover:underline text-blue-400"
                        href={"jobs/create"}
                    >
                        List a job
                    </Link>
                </p>
            )}

        </>
    )
}

export default Index;
