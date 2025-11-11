import {usePage} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Info from "@/Pages/components/body/Info.jsx";
import {useApplication} from "@/hooks/jobs/useApplication.js";
import {useBookmark} from "@/hooks/jobs/useBookmark.js";
import {useDelete} from "@/hooks/jobs/useDelete.js";
import {useReport} from "@/hooks/jobs/useReport.js";

const Show = () => {
    const {job, auth} = usePage().props
    const {user} = auth;

    const {applyForJob, loadingApply} = useApplication()
    const {bookmarkJob, loadingBookmark} = useBookmark()
    const {reportJob, loadingReport} = useReport()
    const {deleteJob, loadingDelete} = useDelete()

    return (
        <>
            <div className="max-w-3xl mx-auto space-y-5">
                <PageHeading title="Job Information"/>

                <Info data={job.title} label="Title"/>

                <div>
                    <p className="text-lg text-white font-semibold">Company:</p>
                    <a href={`/companies/${job.employer.id}/jobs`}
                       className="text-gray-400 text-base hover:underline"
                    >
                        {job.employer.name}
                    </a>
                </div>

                <div>
                    <p className="text-lg text-white font-semibold">About:</p>
                    <div className="prose prose-invert max-w-none text-gray-400">
                        {job.about}
                    </div>
                </div>

                <Info data={job.schedule} label="Schedule"/>
                <Info data={job.location} label="Location"/>
                <Info data={job.salary} label="Salary"/>

                <hr className="text-gray-900"/>

                {!user && (
                    <div className="pt-6 ">

                        <button
                            onClick={() => applyForJob(job)}
                            disabled={loadingApply}
                            className="inline-block mr-1.5 px-6 py-2 border-2 border-green-700 text-white hover:bg-green-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                        >
                            {loadingApply ? 'Applying...' : 'Apply Here'}
                        </button>

                        <button
                            onClick={() => bookmarkJob(job)}
                            disabled={loadingBookmark}
                            className="inline-block mr-1.5 px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                        >
                            {loadingBookmark ? 'Bookmarking...' : 'Bookmark'}
                        </button>
                    </div>
                )}

                {user && user.role === 'user' && (
                    // normal users only
                    <div className="pt-6 flex w-full">
                        <button
                            onClick={() => applyForJob(job)}
                            disabled={loadingApply}
                            className="inline-block mr-1.5 px-6 py-2 border-2 border-green-700 text-white hover:bg-green-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                        >
                            {loadingApply ? 'Applying...' : 'Apply Here'}
                        </button>

                        <button
                            onClick={() => bookmarkJob(job)}
                            disabled={loadingBookmark}
                            className="inline-block mr-1.5 px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                        >
                            {loadingBookmark ? 'Bookmarking...' : 'Bookmark'}
                        </button>

                        <button
                            onClick={() => reportJob(job)}
                            disabled={loadingReport}
                            className="ml-auto inline-block px-6 py-2 border-2 border-red-700 text-white hover:bg-red-700 transition rounded-full cursor-pointer focus:bg-red-700"
                        >
                            {loadingReport ? 'Reporting...' : 'Report Job'}
                        </button>
                    </div>
                )}

                {user && !['admin', 'superadmin', 'user'].includes(user.role) && (
                    <div className="pt-6">
                        <button
                            onClick={() => reportJob(job)}
                            disabled={loadingReport}
                            className="ml-auto inline-block px-6 py-2 border-2 border-red-700 text-white hover:bg-red-700 transition rounded-full cursor-pointer focus:bg-red-700"
                        >
                            {loadingReport ? 'Reporting...' : 'Report Job'}
                        </button>
                    </div>
                )}

                {user && ['admin', 'superadmin'].includes(user.role) && (
                    <div className="pt-6 flex w-full">
                        <button
                            onClick={() => deleteJob(job)}
                            className="ml-auto inline-block px-6 py-2 border-2 border-red-700 text-white hover:bg-red-700 transition rounded-full cursor-pointer focus:bg-red-700"
                        >
                            {loadingDelete ? 'Deleting...' : 'Delete Job'}
                        </button>
                    </div>
                )}
            </div>
        </>
    )
}

export default Show;
