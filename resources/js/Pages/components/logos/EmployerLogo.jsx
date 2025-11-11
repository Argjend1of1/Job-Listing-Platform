const EmployerLogo = ({employer, width = 90}) =>{
    return (
        <img
            className="rounded-full"
            alt={"logo"}
            src={'storage/logos/default-logo.png' /*will be employer.logo on prod*/}
            width={width}
        />
    )
}

export default EmployerLogo;
