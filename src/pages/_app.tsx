import { type Session } from "next-auth";
import { SessionProvider } from "next-auth/react";
import { type AppType } from "next/app";
import type { ReactNode } from "react";

import { api } from "~/utils/api";
import Layout from "~/components/Layout";

import "~/styles/globals.css";

type NextPageWithLayout = { getLayout?: (page: ReactNode) => ReactNode };

const MyApp: AppType<{ session: Session | null }> = ({
  Component,
  pageProps: { session, ...pageProps },
}) => {
  const getLayout = (Component as NextPageWithLayout).getLayout
    ?? ((page: ReactNode) => <Layout>{page}</Layout>);

  return (
    <SessionProvider session={session}>
      {getLayout(<Component {...pageProps} />)}
    </SessionProvider>
  );
};

export default api.withTRPC(MyApp);
