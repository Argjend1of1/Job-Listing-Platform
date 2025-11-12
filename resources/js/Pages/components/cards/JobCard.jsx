import Panel from "../Panel.jsx";
import {Link} from "@inertiajs/react";
import EmployerLogo from "../logos/EmployerLogo.jsx";

const JobCard = ({job, route = `/jobs/${job.id}`}) => {

    return (
        <Panel className={'flex-col text-center'}>
            <Link
                href={`/companies/${job.employer?.id}/jobs`}
                className={'self-start text-sm hover:underline'}
            >
                {job.employer?.name}
            </Link>

            <div className={'py-8'}>
                <h3 className={"font-bold group-hover:text-blue-900 transition-colors duration-200"}>
                    <Link href={route}>
                        {job.title}
                    </Link>
                </h3>
                <p className="text-xs text-gray-400 mt-1.5">{job.schedule}- {job.salary}</p>
            </div>

            <div className="flex justify-between items-center mt-auto">
                <div>
                    {job.tags?.map((tag) => (
                        <Link
                            className={'bg-white/15 rounded-xl font-bold transition-colors duration-200 hover:bg-white/25 text-[10px] px-3.5 py-1 mx-0.5'}
                            href={`/tags/${tag.name?.toLocaleLowerCase()}`}
                            key={tag.id}
                        >
                            {tag.name}
                        </Link>
                    ))}
                </div>

                {/*<EmployerLogo employer={job.employer?.user} width={42} />*/}
            </div>
        </Panel>
    )
}

export default JobCard
