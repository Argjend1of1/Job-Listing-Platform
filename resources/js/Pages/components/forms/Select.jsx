import Option from './Option.jsx'
import {usePage} from "@inertiajs/react";
import Label from "@/Pages/components/forms/Label.jsx";
const Select = ({value, onChange, name, label}) =>{
    const {categories} = usePage().props;

    return (
        <>
            {label && (
                <Label name={name} label={label} />
            )}
            <select
                id={name}
                name={name}
                value={value}
                onChange={onChange}
                className="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full"
            >
                <option className={"text-black"} value="">-Select a category-</option>
                {categories.map((category) => (
                    <Option key={category.id} category={category} />
                ))}
            </select>
        </>
    )


}

export default Select;
