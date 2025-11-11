import {usePage} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import ApplicantCard from "@/Pages/components/ApplicantCard.jsx";
import Pagination from "@/Pages/components/Pagination.jsx";
import {showError} from "@/reusableFunctions/alertUser.js";

const Show = () => {
    const {applications, job, flash} = usePage().props

    if (flash.error) {
        showError(flash.error, 2000)
    }

    return (
        <>
            <PageHeading title={`Applicants for ${job.title} Job`} />

            <div className="flex flex-col justify-around">
                <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">
                    {applications.data.length > 0 &&
                        applications.data.map((application) => (
                                <div key={application.id}>
                                    <ApplicantCard application={application} job={job}/>
                                </div>
                            )
                        )}
                </div>

                {applications.data.length > 10 && <Pagination links={applications.links} />}
            </div>
        </>
    )
}

export default Show;
