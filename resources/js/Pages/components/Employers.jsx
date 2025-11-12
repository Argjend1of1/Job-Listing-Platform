import {useForm} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import QueryInput from "@/Pages/components/forms/QueryInput.jsx";
import {Fragment, useEffect, useRef} from "react";
import {queryLogic} from "@/reusableFunctions/queryLogic.js";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";
import EmployerCardWide from "@/Pages/components/cards/EmployerCardWide.jsx";

const Employers = ({employers, query, endpoint, reset, title}) => {
    const {data, setData} = useForm({q: query})
    const cancelToken = useRef(null);

    useEffect(() => {
        const delayDebounce = queryLogic(
            endpoint, data, query, cancelToken, 'employers'
        )

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
        <>
            <section>
                <PageHeading title={
                    query === ''
                        ? title
                        : `Search Results for '${query}'`
                } />

                <Form>
                    <QueryInput
                        setData={setData}
                        data={data}
                        placeholder={'Search For Employer...'}
                    />
                </Form>

                {employers.data.length > 0 ? (
                    <InfiniteScrolling data={'employers'}>
                        {employers.data.map((employer) => (
                            <Fragment key={employer.id}>
                                <EmployerCardWide employer={employer} />
                            </Fragment>
                        ))}
                    </InfiniteScrolling>
                ) : (
                    <p className="text-lg text-gray-500 mt-10">No employer found.</p>
                )}
            </section>
        </>
    )
}

export default Employers;
