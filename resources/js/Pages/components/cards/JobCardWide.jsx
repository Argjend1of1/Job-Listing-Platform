const JobCardWide = ({user, job, logo}) => {
    const tagsHtml = job.tags?.map(tag => (
        <span key={tag.id} className="bg-gray-700 text-white text-[10px] px-3 py-1 rounded-full">{tag.name}</span>
    ));

    return (
        <div className="p-4 bg-white/10 rounded-xl mt-3 flex border border-transparent hover:border-blue-900 cursor-pointer group transition-colors duration-200">
            <div>
                <img src={logo}
                     alt={user.employer.name}
                     className="rounded-full flex items-center justify-center"
                     width="90"
                     height="90"
                />
            </div>

            <div className="flex-1 flex flex-col ml-3">
                <a
                    href={`/companies/${user.employer.id}/jobs`}
                    className="self-start text-sm text-gray-400 hover:underline"
                >
                    {user.employer.name}
                </a>
                <a
                    href={`/jobs/${job.id}`}
                    className="font-bold text-xl mt-1 group-hover:text-blue-900 transition-colors duration-200"
                >
                    {job.title}
                </a>
                <p className="text-sm text-gray-400 mt-auto">
                    {job.schedule} - {job.salary}
                </p>
            </div>
            <div className="flex flex-col justify-between py-2 px-3 items-end">
                <div className="flex flex-wrap gap-2 ">
                    {tagsHtml ? tagsHtml : ''}
                </div>
                <div>
                    <a
                        href={`/dashboard/${job.id}/applicants`}
                        className="rounded px-2 text-gray-400 font-medium mt-3 hover:underline cursor-pointer"
                    >
                        See Applicants
                    </a>
                    <a
                        href={`/dashboard/edit/${job.id}`}
                        className="rounded px-2 text-gray-400 font-medium mt-3 hover:underline cursor-pointer"
                    >
                        Edit Job
                    </a>
                </div>
            </div>
        </div>
    )
}

export default JobCardWide;
