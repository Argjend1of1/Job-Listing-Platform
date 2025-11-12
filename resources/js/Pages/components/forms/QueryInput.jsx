import Input from "@/Pages/components/forms/Input.jsx";

const QueryInput = ({ placeholder, data, setData }) => {
    return (
        <Input
            name={'q'}
            label={false}
            placeholder={placeholder}
            value={data.q}
            onChange={(e) => setData('q', e.target.value)}
        />
    )
}

export default QueryInput;
