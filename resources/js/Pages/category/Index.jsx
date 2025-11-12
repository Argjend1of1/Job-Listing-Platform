import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import JobCard from "@/Pages/components/cards/JobCard.jsx";
import {Fragment} from "react";
import {InfiniteScroll} from "@inertiajs/react";
import {RotatingLines} from "react-loader-spinner";

const Index = ({ jobs, category }) => {
    console.log(jobs)
    console.log(category)
    return (
        <>
            <PageHeading title={`Jobs listed for ${category.name}`}/>

            <InfiniteScroll data={'jobs'}
                            loading={() => <div className={'flex justify-end my-3'}>
                                <RotatingLines
                                    visible={true}
                                    height="40"
                                    width="40"
                                    color="grey"
                                    strokeWidth="5"
                                    animationDuration="0.75"
                                    ariaLabel="rotating-lines-loading"
                                    wrapperStyle={{}}
                                    wrapperClass=""
                                />
                            </div>}
            >
                {jobs.data.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        {jobs.data.map((job) => (
                            <Fragment key={job.id}>
                                <JobCard job={job} />
                            </Fragment>
                        ))}
                    </div>
                ): (
                    <p className="text-lg text-gray-500 mt-3">No jobs found for this category.</p>
                )}
            </InfiniteScroll>

        </>
    )
}

export default Index;
