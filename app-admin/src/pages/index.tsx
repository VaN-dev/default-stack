import type { NextPage } from 'next';
import { AdminLayout } from '@layout';
import React from 'react';

const Home: NextPage = () => (
  <AdminLayout>
    <div className="row">
      <div className="col-lg-12">
        <p>Welcome to Admin Dashboard.</p>
        <p>
          You can start editing this page in
          <code>/src/pages/index.tsx</code>
        </p>
      </div>
    </div>
  </AdminLayout>
);

export default Home;
