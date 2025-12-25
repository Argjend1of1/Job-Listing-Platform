import Label from "@/Pages/components/forms/Label.jsx";

const Input = ({
   type = "text",
   name,
   label,
   value,
   onChange,
   ref,
   placeholder = ''
}) => {
    return (
        <div>
            {label && (
                <Label name={name} label={label} />
            )}
            <input
                ref={ref}
                type={type}
                id={name}
                name={name}
                onChange={onChange}
                className={'rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full'}
                placeholder={placeholder}
                {...(type === 'checkbox' ? {checked: !!value} : type !== 'file' ? {value} : {})}
            />
            {/*    Basically if we have a file as type we cannot attach a value, for other cases leave as is*/}
        </div>
    )
}

export default Input;
