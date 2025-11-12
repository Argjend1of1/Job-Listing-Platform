import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";
import {Fragment} from "react";
import JobCard from "@/Pages/components/cards/JobCard.jsx";

const Show = ({employer, jobs}) => {
    return (
        <>
            <PageHeading title={`${employer.name}'s Listed Jobs`} />

            {jobs.data.length > 0 ? (
                <InfiniteScrolling data={'jobs'}>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        {jobs.data.map((job) => (
                            <Fragment key={job.id}>
                                <JobCard job={job}/>
                            </Fragment>
                        ))}
                    </div>
                </InfiniteScrolling>
            ) : (
                <p className="text-gray-400 font-semibold mt-3">
                    This company has no jobs listed currently.
                </p>
            )}
        </>
    )
}

export default Show;
