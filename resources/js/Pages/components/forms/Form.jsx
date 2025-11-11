const Form = ({method = "", children, action = "", enctype = ""}) => {
    return (
        <form
            className={"max-w-2xl mx-auto space-y-6"}
            method={method}
            action={action}
            encType={enctype}
        >
            { children }
        </form>
    )
}

export default Form
