import {Link, usePage} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import {useApplication} from "@/hooks/jobs/useApplication.js";
import {useBookmark} from "@/hooks/jobs/useBookmark.js";

const Show = () =>
{
    const {auth, flash, job} = usePage().props
    const {user} = auth

    const {applyForJob, loadingApply} = useApplication()
    const {removeBookmark, loadingBookmark} = useBookmark()

    console.log(user)
    console.log(flash)
    console.log(job)

    return (
        <>
            <div className="max-w-3xl mx-auto space-y-8">
                <PageHeading title="Job Information" />
                <div className="space-y-5">
                    <div>
                        <p className="text-lg text-white font-semibold">Title:</p>
                        <p className="text-gray-400 text-base">{job.title}</p>
                    </div>

                    <div>
                        <p className="text-lg text-white font-semibold">Company:</p>
                        <Link href={`/companies/${job.employer.id}/jobs`}
                           className="text-gray-400 text-base hover:underline"
                        >
                            {job.employer.name}
                        </Link>
                    </div>

                    <div>
                        <p className="text-lg text-white font-semibold">About:</p>
                        <div className="prose prose-invert max-w-none text-gray-400">
                            {job.about}
                        </div>
                    </div>

                    <div>
                        <p className="text-lg text-white font-semibold">Schedule:</p>
                        <p className="text-gray-400 text-base">{job.schedule}</p>
                    </div>

                    <div>
                        <p className="text-lg text-white font-semibold">Location:</p>
                        <p className="text-gray-400 text-base">{job.location}</p>
                    </div>

                    <div>
                        <p className="text-lg text-white font-semibold">Salary:</p>
                        <p className="text-gray-400 text-base">{job.salary}</p>
                    </div>
                    <hr className="text-gray-900"/>

                    {!user && (
                        <div className="pt-6 flex w-full">
                            <button
                                onClick={() => applyForJob(job)}
                                disabled={loadingApply}
                                className="inline-block mr-1.5 px-6 py-2 border-2 border-green-700 text-white hover:bg-green-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                            >
                                {loadingApply ? 'Applying...' : 'Apply Here'}
                            </button>
                        </div>
                    )}

                    {user && user.role === 'user' && (
                        <div className="pt-6 flex w-full">
                            <button
                                onClick={() => applyForJob(job)}
                                disabled={loadingApply}
                                className="inline-block mr-1.5 px-6 py-2 border-2 border-green-700 text-white hover:bg-green-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                            >
                                {loadingApply ? 'Applying...' : 'Apply Here'}
                            </button>

                            <button
                                onClick={() => removeBookmark(job)}
                                disabled={loadingBookmark}
                                className="ml-auto inline-block mr-3 px-6 py-2 border-2 border-yellow-700 text-white hover:bg-yellow-700 transition rounded-full cursor-pointer focus:bg-gray-800"
                            >
                                {loadingBookmark ? 'Removing...' : 'Remove Bookmark'}
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </>
    )

}

export default Show;
