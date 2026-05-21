# Definition of Done (DoD) - PondasiKu

## Definition of Done untuk User Story

Sebuah User Story dianggap **DONE** jika memenuhi semua kriteria berikut:

### 1. Code Quality
- [ ] Code sudah di-review oleh minimal 1 anggota tim lain
- [ ] Tidak ada code smell atau warning di linter
- [ ] Mengikuti coding standard yang disepakati (PSR-12 untuk PHP, ESLint untuk Vue)
- [ ] Tidak ada hardcoded values (gunakan config/env)
- [ ] Proper error handling implemented

### 2. Testing
- [ ] Unit test ditulis dan passing (minimal 70% coverage untuk service layer)
- [ ] Integration test untuk fitur kritikal
- [ ] Manual testing sudah dilakukan
- [ ] Edge cases sudah ditest
- [ ] Negative test cases sudah ditest

### 3. Acceptance Criteria
- [ ] Semua acceptance criteria terpenuhi
- [ ] Validasi input sudah sesuai
- [ ] Response format sesuai API contract
- [ ] Error messages informatif dan user-friendly

### 4. Database
- [ ] Migration file dibuat dan tested
- [ ] Seeder dibuat (jika diperlukan)
- [ ] Indexing untuk query optimization
- [ ] Foreign key constraints proper

### 5. Documentation
- [ ] Kode terbaca dengan penamaan yang jelas
- [ ] Komentar untuk logic kompleks
- [ ] README updated (jika ada perubahan setup)

### 6. Security
- [ ] Input sanitization implemented
- [ ] Authorization checks in place
- [ ] Sensitive data tidak terekspos di response
- [ ] File upload validation (jika ada)

### 7. Performance
- [ ] Query optimization (eager loading, pagination)
- [ ] Response time < 500ms untuk API calls
- [ ] N+1 query problem avoided

### 8. UI/UX (untuk frontend)
- [ ] Responsive design (mobile, tablet, desktop)
- [ ] Loading states implemented
- [ ] Error states handled gracefully
- [ ] Browser compatibility tested (Chrome, Firefox, Safari, Edge)

### 9. Version Control
- [ ] Branch created dari `develop`
- [ ] Commit messages mengikuti conventional commits
- [ ] Pull Request created dengan deskripsi jelas
- [ ] No merge conflicts

### 10. Deployment
- [ ] Environment variables documented
- [ ] Tested di local environment
- [ ] Tested di staging environment (jika sudah ada)

---

## Deployment Checklist (Free Tier)

### Frontend (Vercel)
- [ ] Project connected ke GitHub
- [ ] Build command: `npm run build`
- [ ] Output directory: `dist`
- [ ] Environment variables set (API URL, dll)
- [ ] Domain configured (vercel.app subdomain)

### Backend (Railway)
- [ ] Project connected ke GitHub
- [ ] Start command: `php artisan serve --host 0.0.0.0 --port $PORT`
- [ ] Environment variables set (DB, APP_KEY, dll)
- [ ] Database connected (Supabase)
- [ ] Storage configured (Cloudflare R2/local)
- [ ] Build command: `composer install && php artisan migrate --force`

### Database (Supabase)
- [ ] Project created
- [ ] Migrations run
- [ ] Connection string configured di backend

---

## Definition of Done untuk Sprint

Sebuah Sprint dianggap **DONE** jika:

- [ ] Semua User Story yang di-commit sudah DONE
- [ ] Sprint Review meeting sudah dilakukan
- [ ] Sprint Retrospective sudah dilakukan
- [ ] Product Backlog updated
- [ ] Velocity calculated dan documented
- [ ] Demo ke stakeholder sudah dilakukan

---

## Definition of Done untuk Release

Sebuah Release dianggap **DONE** jika:

- [ ] Semua Sprint dalam release sudah DONE
- [ ] Regression testing passed
- [ ] Performance testing passed
- [ ] User Acceptance Testing (UAT) passed
- [ ] Staging environment ready
- [ ] Documentation complete

---

## Code Review Checklist

### Backend (Laravel)
- [ ] Mengikuti PSR-12 coding standard
- [ ] Proper use of Eloquent ORM
- [ ] Form Request untuk validation
- [ ] Middleware untuk auth/role check
- [ ] Exception handling proper
- [ ] Logging implemented untuk critical operations

### Frontend (Vue 3 + Inertia)
- [ ] Composition API used
- [ ] Props validation
- [ ] Proper component structure
- [ ] Loading states handled
- [ ] Responsive design verified

---

## Testing Standards

### Unit Test Coverage Target
| Layer | Minimum Coverage |
|-------|------------------|
| Services | 70% |
| Controllers | 50% |
| Models | 60% |

### Test Categories
1. **Unit Test** - Test individual functions/methods
2. **Feature Test** - Test fitur/endpoints
3. **Integration Test** - Test interaction antar komponen

### Test Naming Convention
```
test_{method_name}_{scenario}_{expected_result}

// Example
test_create_order_valid_input_success
test_create_order_out_of_stock_throws_exception
test_login_invalid_password_returns_error
```

---

## Git Workflow

### Branch Naming
```
feature/{ticket-id}-{short-description}
bugfix/{ticket-id}-{short-description}
hotfix/{ticket-id}-{short-description}
release/{version}

// Example
feature/US-016-add-to-cart
bugfix/US-023-payment-callback-error
release/v1.0.0
```

### Commit Message Format
```
type(scope): subject

// Types: feat, fix, docs, style, refactor, test, chore

// Example
feat(cart): implement add to cart functionality
fix(payment): handle callback timeout error
docs(api): update order endpoint documentation
```

### Pull Request Template
```markdown
## Description
Brief description of changes

## Related Ticket
Closes #US-XXX

## Type of Change
- [ ] Feature
- [ ] Bug Fix
- [ ] Refactoring
- [ ] Documentation

## Testing
- [ ] Unit test added
- [ ] Manual testing done

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
```

---

## Quality Gates

| Metric | Threshold |
|--------|-----------|
| Code Coverage | ≥ 70% |
| Cyclomatic Complexity | ≤ 10 per method |
| Security Rating | Pass |

---

## Sign-off Requirements

### User Story Sign-off
- Developer: Code complete & tested
- Reviewer: Code review approved
- Product Owner: Acceptance criteria met

### Release Sign-off
- Tech Lead: Technical readiness
- Product Owner: Business acceptance
- Stakeholder: Final approval
