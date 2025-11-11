const Option = ({category}) => {
    return (
        <option
            value={category.name}
            className={"text-black"}
        >
            {category.name}
        </option>
    )
}

export default Option;
