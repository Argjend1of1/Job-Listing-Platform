import Panel from "@/Pages/components/Panel.jsx";
import EmployerLogo from "@/Pages/components/logos/EmployerLogo.jsx";

const ApplicantCard = ({application, job}) => {
    const {user_id} = application

    return (
        <Panel className="flex-col text-center">
            <div className="py-3">
                <h3 className="font-bold  text-2xl group-hover:text-blue-900 transition-colors duration-200">
                    {application.user.name}
                </h3>
                <p className="text-sm text-gray-400 mt-1.5">{application.user.email}</p>
            </div>

            <div className="flex justify-between items-center mt-auto">
                <a
                    href={`/resume/${user_id}/${job.id}/`}
                    className="flex items-center border-2 border-green-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-green-800 cursor-pointer"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <p className="mr-3">Resume</p>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         className="w-4 h-4 mr-1"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"
                        />
                    </svg>
                </a>

                <EmployerLogo employer={application.user} width={45}/>
            </div>
        </Panel>
    )
}

export default ApplicantCard;
