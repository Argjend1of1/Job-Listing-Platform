import Label from "@/Pages/components/forms/Label.jsx";

const Field = ({label, name, children}) => {
    return (
        <div>
            {label &&
                <Label
                    label={label}
                    name={name}
                />
            }
            <div className={"mt-1"}>
                {children}
            </div>
        </div>
    )
}

export default Field
