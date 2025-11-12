import Panel from "@/Pages/components/Panel.jsx";
import { Link } from "@inertiajs/react";

const EmployerCard = ({ employer }) => {
    return (
        <Panel className={'flex-col text-center'}>
            <div className="py-8">
                <h3 className="font-bold group-hover:text-blue-900 transition-colors duration-200 hover:underline">
                    <Link href={`/companies/${employer.id}/jobs`}>
                        {employer.name}
                    </Link>
                </h3>
                <Link href={`/categories/${employer.category?.name}`}
                   className="text-xs text-gray-400 mt-1.5 hover:underline"
                >
                    {employer.category?.name}
                </Link>
            </div>

            <div className="flex justify-center items-center mt-auto">
                <img src={employer.logo}
                     alt={employer.name}
                     className={'rounded-full'}
                     width="40"
                     height="40"
                />
            </div>
        </Panel>
    )
}

export default EmployerCard;
