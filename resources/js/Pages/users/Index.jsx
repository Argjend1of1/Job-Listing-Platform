import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import {Fragment, useEffect, useRef} from "react";
import {useForm} from "@inertiajs/react";
import Form from "@/Pages/components/forms/Form.jsx";
import QueryInput from "@/Pages/components/forms/QueryInput.jsx";
import {queryLogic} from "@/reusableFunctions/queryLogic.js";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";
import UserCard from "@/Pages/components/cards/UserCard.jsx";

const Index = ({users, query}) => {
    const {data, setData} = useForm({q: query})
    const cancelToken = useRef(null);

    useEffect(() => {
        const delayDebounce = queryLogic(
            '/admins/create', data, query, cancelToken, 'users'
        )

        return () => clearTimeout(delayDebounce);
    }, [data.q])
    return (
        <>
            <PageHeading title={query ? `Search Results for '${query}'` : 'Users'}/>

            <Form>
                <QueryInput
                    data={data}
                    setData={setData}
                    placeholder={'Search Users...'}
                />
            </Form>

            {users.data.length > 0 ? (
                <InfiniteScrolling data={'users'}>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        {users.data.map((user) => (
                            <Fragment key={user.id}>
                                <UserCard user={user}/>
                            </Fragment>
                        ))}
                    </div>
                </InfiniteScrolling>
            ) : (
                <p></p>
            )}



        </>
    )
}

export default Index;
