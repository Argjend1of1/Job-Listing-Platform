import {Link} from "@inertiajs/react";

const ReportCard = ({ report }) => {
    const {job} = report;       // reported job
    const {employer} = job;     // employer who published the job
    const {user} = report       // user who reported the job

    return (
        <div className="bg-white/10 rounded-xl mt-4 p-5 hover:shadow-lg hover:border border-blue-800 cursor-pointer transition duration-300 space-y-5">
            <div>
                <p className="text-sm text-gray-300 font-medium">📄 Reported Job:</p>
                <Link href={`/jobs/${report.job.id}`}
                      className="text-xl font-semibold text-white hover:underline cursor-pointer"
                >
                    {report.job.title}
                </Link>
            </div>

            <div>
                <p className="text-sm text-gray-300 font-medium">🏢 Published By:</p>
                <Link href={`/companies/${employer.id}/jobs`} className="text-white font-semibold">
                    {employer.user.name}
                    <span className="text-sm text-gray-400">({employer.user.email})</span>
                </Link>
            </div>

            <hr className="border-gray-700"/>

            <div>
                <p className="text-sm text-gray-300 font-medium">🧑‍💼 Reported By:</p>
                <p className="text-white font-semibold text-sm">
                    { user.employer
                        ? `${user.name} of ${user.employer.name} company`
                        : user.name
                    }
                    <br/>
                    <span className="text-sm text-gray-400">Email: ({ user.email })</span>
                </p>
            </div>
        </div>
    )
}

export default ReportCard;
